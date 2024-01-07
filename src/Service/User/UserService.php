<?php
namespace App\Service\User;

use App\Entity\User;
use App\Manager\User\UserManager;

class UserService
{
    public function __construct(
        private readonly UserManager $userManager,
    )
    {
    }

    public function findById(int $id): ?User
    {
        return $this->userManager->findById($id);
    }
}