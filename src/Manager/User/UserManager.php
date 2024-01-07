<?php

namespace App\Manager\User;

use App\Entity\User;
use App\Repository\User\UserRepository;

class UserManager
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ?User
    {
        return $this->userRepository->findByUsernameOrEmail($usernameOrEmail);
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }
}
