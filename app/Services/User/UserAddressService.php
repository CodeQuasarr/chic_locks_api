<?php

namespace App\Services\User;

use App\Interfaces\User\UserAddressServiceInterface;
use App\Models\User;
use App\Models\User\UserAddress;
use App\Repositories\User\UserAddressRepository;
use App\Services\BaseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserAddressService extends BaseService implements UserAddressServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct( private readonly UserAddressRepository $userAddressRepository)
    {}

    public function create(User $authUser, User $user, array $data): UserAddress
    {

        if ($authUser->getKey() !== $user->getKey()) {
            throw new AccessDeniedHttpException('You do not have permission to access this resource.');
        }

        if ($data['is_default'] && $user->addresses()->where('is_default', true)->exists()) {
            $validator = Validator::make([], []); // Créer un validateur vide
            $validator->errors()->add('is_default', 'You can only have one default address.'); // Ajouter une erreur
            throw new ValidationException($validator);
        }

        $fields = $this->getModelFields($this->userAddressRepository->getInstanceOfUser(), collect($data));

        DB::beginTransaction();

        $userAddress = $this->userAddressRepository->create($user, $fields->toArray());

        if (!$userAddress) {
            DB::rollBack();
            throw new RuntimeException('Un problème est survenu lors de la création de l\'utilisateur.', 500);
        }
        DB::commit();
        return $userAddress;
    }

    public function update(array $data, string $id): void
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }
}
