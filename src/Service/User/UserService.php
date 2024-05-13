<?php
namespace App\Service\User;

use App\Entity\User;
use App\Manager\User\UserManager;
use App\Traits\DataHydration\Hydrate;

class UserService
{
    use Hydrate;
    public function __construct(private readonly UserManager $userManager)
    {
    }

    public function findById(int $id): ?User
    {
        $user = $this->userManager->findById($id);

        if (!$user instanceof User) {
            return null;
        }

        return $this->hydrate($user);
    }

    private function hydrate(User $user): User
    {
        return $this->hydrateUser($user);
    }
}
