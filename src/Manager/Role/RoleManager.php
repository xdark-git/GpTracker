<?php

namespace App\Manager\Role;

use App\Repository\Role\RoleRepository;
use App\Entity\Role;

class RoleManager
{
    public function __construct(private readonly RoleRepository $roleRepository)
    {
    }

    public function findById(int $id): ?Role
    {
        return $this->roleRepository->findById($id);
    }
}