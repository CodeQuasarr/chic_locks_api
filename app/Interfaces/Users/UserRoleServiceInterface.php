<?php

namespace App\Interfaces\Users;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

interface UserRoleServiceInterface
{

    public function updateRole(Collection $roles, ProgressBar $bar): void;

    public function createRole(string $name, string $description): void;

}
