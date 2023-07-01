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
    
    public function createUser(string $email, string $password, Role $role): User
    {
        $user = new User();
        $user->setEmail($email)->setRole($role);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPassword);

        return $user;
        
    }
}