<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'description', 'guard_name'];
    public const READ_MY_PROFILE = 'read_my_profile';
    public const UPDATE_MY_PROFILE = 'update_my_profile';
    public const DELETE_MY_PROFILE = 'delete_my_profile';

    public const READ_USERS = 'read_users';
    public const CREATE_USERS = 'create_users';
    public const UPDATE_USERS = 'update_users';
    public const DELETE_USERS = 'delete_users';
    public const FORCE_DELETE_USERS = 'force_delete_users';

    public static function static_getPermissions(): SupportCollection {
        return new Collection([
            self::READ_MY_PROFILE => __("user.permissions.permission_names.read_my_profile"),
            self::UPDATE_MY_PROFILE => __("user.permissions.permission_names.update_my_profile"),
            self::DELETE_MY_PROFILE => __("user.permissions.permission_names.delete_my_profile"),

            self::READ_USERS => __("user.permissions.permission_names.read_users"),
            self::CREATE_USERS => __("user.permissions.permission_names.create_users"),
            self::UPDATE_USERS => __("user.permissions.permission_names.update_users"),
            self::DELETE_USERS => __("user.permissions.permission_names.delete_users"),
            self::FORCE_DELETE_USERS => __("user.permissions.permission_names.force_delete_users"),
        ]);
    }

    public static function static_getPermissionsByRoleName(string $roleName): array|Collection|null
    {
        return match ($roleName) {
            Role::ADMIN => self::all(),
            Role::MODERATOR => self::static_getPermissions_moderator(),
            Role::CLIENT => self::static_getPermissions_client(),
            default => null,
        };
    }

    private static function static_getPermissions_moderator(): array
    {
        return [
            self::READ_MY_PROFILE,
            self::UPDATE_MY_PROFILE,
            self::DELETE_MY_PROFILE,

            self::READ_USERS,
            self::UPDATE_USERS,
        ];
    }

    private static function static_getPermissions_client(): array
    {
        return [
            self::READ_MY_PROFILE,
            self::UPDATE_MY_PROFILE,
            self::DELETE_MY_PROFILE,
        ];
    }
}
