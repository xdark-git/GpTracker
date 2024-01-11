<?php

namespace App\Traits\DataHydration;

use App\Entity\User;
use App\Manager\Role\RoleManager;
use App\Entity\Role;

trait Hydrate {
    private function hydrateUser(User $user, int $depth = 0): User
    {
        if ($depth >= 3) {
            return $user;
        }

        $depth++;
        
        // TODO: fix bug here
        /** @var RoleManager $roleManger */
        $roleManager = $this->container->get(RoleManager::class);

        $role = $roleManager->findById($user->getRoleId());

        if ($role instanceof Role) {
            $user->setRoles(array_unique([$role->getName()]));
        }

        $user->setRoles($user->getRoles());

        return $user;
    }
}