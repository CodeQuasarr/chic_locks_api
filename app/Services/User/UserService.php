<?php

namespace App\Services\User;

use App\Interfaces\User\UserServiceInterface;
use App\Models\User;
use App\Models\User\Role;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseService implements UserServiceInterface
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {}

    /**
     * @description Get user by email
     *
     * @param string $email
     * @return User
     * @throws AuthenticationException
     */
    public function getUserByEmail(string $email): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new AuthenticationException(__("auth.failed"));
        }

        return $user;
    }

    public function createUser(array $data): User
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

    /**
     * Récupérer un utilisateur par ID avec vérification d'autorisation.
     */
    public function showUserById(int $id): User
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw new ModelNotFoundException("User not found", Response::HTTP_NOT_FOUND);
        }

        // Vérification des permissions avec Policy
        Gate::authorize('view', $user);

        return $user;
    }

    public function updateUser(array $data, User $user): User
    {
        $fields = $this->getModelFields($user, collect($data));

        if ($fields->has('password')) {
            $fields->put('password', Hash::make($fields->get('password')));
        }
        DB::beginTransaction();
        $success = $this->userRepository->update($fields->toArray(), $user);

        if (!$success) {
            DB::rollBack();
            throw new RuntimeException('Un problème est survenu lors de la mise à jour de l\'utilisateur.', 500);
        }

        DB::commit();
        return $user;
    }
}
