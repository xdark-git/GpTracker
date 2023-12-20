<?php

use App\Manager\UserManager;

class UserService
{
    public function __construct(
        private readonly UserManager        $userManager,
    )
    {
    }
}