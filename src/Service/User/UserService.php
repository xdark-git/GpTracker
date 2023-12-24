<?php
namespace App\Service\User;

use App\Manager\UserManager;

class UserService
{
    public function __construct(
        private readonly UserManager $userManager,
    )
    {
    }

    public function findById(int $id)
    {
        return $this->userManager->findById($id);
    }
}