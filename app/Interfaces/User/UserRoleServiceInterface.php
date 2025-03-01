<?php

namespace App\Interfaces\User;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

interface UserRoleServiceInterface
{

    public function updateRole(Collection $roles, ProgressBar $bar): void;
}
