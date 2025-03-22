<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\RegisterServiceInterface;
use App\Models\User;
use App\Repositories\Users\UserRepository;
use App\Services\BaseService;
use App\Services\Users\UserService;
use Exception;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RegisterService extends BaseService implements RegisterServiceInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserService $userService,
    )
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
        $userExists = $this->userRepository->findByEmail($data['email']);

        if ($userExists) {
            throw new ConflictHttpException('Cet email est déjà utilisé.');
        }

        return $this->userService->createUser($data);
    }
}
