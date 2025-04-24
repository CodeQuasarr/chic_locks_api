<?php

namespace App\Services\Users;

use App\Interfaces\Users\UserAddressServiceInterface;
use App\Models\User;
use App\Models\Users\UserAddress;
use App\Repositories\Users\UserAddressRepository;
use App\Services\BaseService;
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
    public function __construct(
        private readonly UserAddressRepository $userAddressRepository,
    )
    {}

    public function create(User $authUser, User $user, array $data): UserAddress
    {
        if ($authUser->getKey() !== $user->getKey()) {
            throw new AccessDeniedHttpException('You do not have permission to access this resource.');
        }

        if ($data['is_default'] && $user->addresses()->where('is_default', true)->exists()) {
            // remove the default address from the previous one
            $user->addresses()->where('is_default', true)->update(['is_default' => false]);
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
