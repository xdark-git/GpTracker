<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Repository\Role\RoleRepository;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role extends BaseEntity
{
    use TimestampableEntity;

    // table fields
    public const TABLE          = "role";
    public const ID             = "id";
    public const NAME           = "name";
    public const CREATED_AT     = "createdAt";
    public const UPDATED_AT     = "updatedAt";

    public const ROLE_ADMIN     = "ROLE_ADMIN";
    public const ROLE_USER      = "ROLE_USER";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60, nullable: false, unique: true)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
