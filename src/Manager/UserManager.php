<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\User\UserRepository;

class UserManager
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }
}
