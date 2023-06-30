<?php 
namespace Viewpoint\AdminBundle\Traits;

use Viewpoint\AdminBundle\Entity\Role;
use Viewpoint\AdminBundle\Entity\User;

trait AdminTrait{

    public function createRole(string $name){
        $role = new Role();
        $role->setName($name);

        return $role;
    }
    
    public function createUser(string $email, string $password, Role $role){
        $user = new User();
        $user->setEmail($email)
            ->setPassword($password)
            ->setRole($role);

        return $user;
        
    }
}