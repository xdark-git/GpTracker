<?php

namespace App\Traits\DataHydration;

use App\Entity\User;
use App\Manager\Role\RoleManager;
use App\Entity\Role;
use App\Service\ServiceLocator;

trait Hydrate {
    private function hydrateUser(User $user, int $depth = 0): User
    {
        if ($depth >= 3) {
            return $user;
        }

        $depth++;
        
        /** @var RoleManager */
        $roleManager = ServiceLocator::get(RoleManager::class);

        $role = $roleManager->findById($user->getRoleId());

        if ($role instanceof Role) {
            $user->setRoles($role->getName());
        }

        return $user;
    }
}