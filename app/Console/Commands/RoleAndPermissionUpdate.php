<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleAndPermissionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:roles-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Metre à jour les roles et permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Disable foreign key constraints to avoid problems when truncating tables
        // Temporarily disable mass assignment protection on the model
        Schema::disableForeignKeyConstraints();
        Model::unguard();

        // Truncate specified tables to delete all existing records
        $this->truncate("model_has_permissions");
        $this->truncate("permissions");

        // Reactivate protection against mass assignment on the model
        // Re-enable foreign key constraints after table truncation
        Model::reguard();
        Schema::enableForeignKeyConstraints();

        // Update roles and permissions
        $this->updateRoles();
        $this->updatePermissions();

        $this->info('Mise à jour des Liens Roles/Permissions');

        $roles = Role::static_getRoles();
        $bar = $this->output->createProgressBar($roles->count());
        $bar->start();

        foreach ($roles as $name => $description) {
            $this->synchronizeRolesPermissions($name);
            $bar->advance();
        }

        $this->info('');
        $userCount = User::count();
        if ($userCount === 0) {
            $this->info('Aucun utilisateur fictif trouvé');
            return;
        }

        $bar->finish();
        $this->info('');
        $this->info('');

        $this->info('Terminé');
    }

    /**
     * @description Updates roles in the database.
     * * This method retrieves static roles from the Role
     * * class and compares them with the current roles in the database.
     * * New roles are added and old roles are updated.
     *
     * @return void
     */
    private function updateRoles(): void
    {

        $this->info('Mise à jour des roles');
        $roles = Role::static_getRoles();
        $bar = $this->output->createProgressBar($roles->count());
        $bar->start();
        foreach ($roles as $name => $description) {
            $role = Role::firstOrNew(
                ['name' => $name],
                ['description' => $description, 'guard_name' => 'api']
            );

            $role->save();
            $bar->advance();
        }
        $bar->finish();
        $this->info('Mise à jour des roles terminée');
        $this->info('');
    }

    /**
     * @description Updates permissions in the database.
     * This method retrieves static permissions from the Permission
     * class and compares them with the current permissions in the database.
     * New permissions are added and old ones are updated.
     *
     * @return void
     */
    private function updatePermissions(): void
    {
        $this->info('Mise a jour des Permissions');
        $permissions = Permission::static_getPermissions();
        $bar = $this->output->createProgressBar($permissions->count());
        $bar->start();

        foreach ($permissions as $name => $description) {
            $permission = Permission::firstOrNew(
                ['name' => $name],
                ['description' => $description, 'guard_name' => 'api']
            );
            $permission->save();
            $bar->advance();
        }
        $bar->finish();
        $this->info('Mis à jour des permissions terminée');
        $this->info('');
    }

    /**
     * @description Synchronizes permissions for a given role.
     * This method revokes all current permissions for the specified role,
     * then assigns new permissions based on configuration.
     *
     * @param string $roleName
     * @return void
     */
    private function synchronizeRolesPermissions(string $roleName): void
    {
        $this->info("Permissions -> Role : $roleName");

        $role = Role::findByName($roleName, 'api');
        $role->revokePermissionTo(Permission::all());

        $permissions = Permission::static_getPermissionsByRoleName($roleName);

        if ($permissions) {
            $role->givePermissionTo($permissions);
        } else {
            $this->alert("Non configuré pour ce role : $roleName !");
        }
    }

    /**
     * @description Truncate a table with foreign key checks disabled and re-enabling them afterwards. This is useful for truncating tables
     * @param $table
     * @return void
     */
    private function truncate($table): void
    {
        if (DB::getDefaultConnection() === 'mysql') {
            DB::table($table)->truncate();
            return;
        }
    }
}
