<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\RegisterServiceInterface;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class RegisterService extends BaseService implements RegisterServiceInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {}

    /**
     * @description Register user
     *
     * @param array<string, mixed> $data
     * @return User
     * @throws Exception
     */
    public function register(array $data): User
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
