<?php

namespace App\Service\User;

use App\Entity\Role;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use App\Entity\User;
use App\Manager\Role\RoleManager;
use App\Manager\User\UserManager;

class UserProviderService implements UserProviderInterface, PasswordUpgraderInterface
{

    public function __construct(
        private readonly UserManager $userManager,
        private readonly RoleManager $roleManager,
    )
    {}
      /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me. If you're not using these features, you do not
     * need to implement this method.
     *
     * @throws UserNotFoundException if the user is not found
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
       return $this->fetchUser($identifier);
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            // TODO: translate error response
            throw new UnsupportedUserException('user not found');
        }

        return $this->fetchUser($user->getUsername());
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);
    }

    private function fetchUser(string $identifier): User
    {
        $user = $this->userManager->findByUsernameOrEmail($identifier);

        if (!$user instanceof User) {
            // TODO: translate error response
            throw new UserNotFoundException('user not found');
        }

        $role = $this->roleManager->findById($user->getRoleId());
        $user->setRoles(array_unique([$role->getName()]));

        return $user;
    }
}