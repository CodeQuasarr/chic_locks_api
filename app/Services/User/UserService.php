<?php

namespace App\Services\User;

use App\Interfaces\User\UserServiceInterface;
use App\Models\User;
use App\Models\User\Role;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
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

    /**
     * Récupérer un utilisateur par ID avec vérification d'autorisation.
     */
    public function showById(int $id): User
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw new ModelNotFoundException("User not found", Response::HTTP_NOT_FOUND);
        }

        // Vérification des permissions avec Policy
        Gate::authorize('view', $user);

        return $user;
    }
}
