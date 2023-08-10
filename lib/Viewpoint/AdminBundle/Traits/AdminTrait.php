<?php 
namespace Viewpoint\AdminBundle\Traits;

use Viewpoint\AdminBundle\Entity\Role;
use Viewpoint\AdminBundle\Entity\User;

trait AdminTrait{

    public function createRole(string $name): Role
    {
        $role = new Role();
        $role->setName($name);

        return $role;
    }
    
    public function createUser(string $email, string $username, string $password, Role $role, bool $isVerified = false): User
    {
        $user = new User();
        $user->setEmail($email)
            ->setRole($role)
            ->setUsername($username)
            ->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->setIsVerified($isVerified);

        return $user;
        
    }
}