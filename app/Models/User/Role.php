<?php

namespace App\Models\User;

use Illuminate\Support\Collection;
use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public const ADMIN = "administrator";
    public const MODERATOR = "moderator";
    public const CLIENT = "client";


    public static function static_getRoles(): Collection
    {
        return new Collection([
            self::ADMIN => __("Administrateur"),
            self::MODERATOR         => __("Modérateur"),
            self::CLIENT        => __("Client"),
        ]);
    }
}
