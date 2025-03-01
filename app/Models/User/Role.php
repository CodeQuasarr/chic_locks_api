<?php

namespace App\Models\User;

use Illuminate\Support\Collection;
use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    protected $fillable = ['name', 'description', 'guard_name'];
    public const ADMIN = "administrator";
    public const MODERATOR = "moderator";
    public const CLIENT = "client";


    public static function static_getRoles(): Collection
    {
        return new Collection([
            self::ADMIN => __("user.role_names.administrator"),
            self::MODERATOR         => __("user.role_names.moderator"),
            self::CLIENT        => __("user.role_names.client"),
        ]);
    }
}
