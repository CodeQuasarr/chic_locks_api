<?php

namespace App\Services\User;

use App\Interfaces\User\UserServiceInterface;
use App\Models\User;
use App\Models\User\Role;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserService extends BaseService implements UserServiceInterface
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {}

    public function create(array $data): User
    {
        $fields = $this->getModelFields($this->userRepository->getInstanceOfUser(), collect($data));
        $fields->put('password', Hash::make($fields->get('password')));

        DB::beginTransaction();
        $user = $this->userRepository->create($fields->toArray());

        if (!$user) {
            DB::rollBack();
            throw new RuntimeException('Un problème est survenu lors de la création de l\'utilisateur.', 500);
        }
        DB::commit();
        return $user;
    }
}
