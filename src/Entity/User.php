<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use DateTime;
use App\Repository\User\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends BaseEntity
{
    use TimestampableEntity;

    // table fields
    public const TABLE          = "user";
    public const ID             = "id";
    public const FIRST_NAME     = "first_name";
    public const LAST_NAME      = "last_name";
    public const SEXE           = "sexe";
    public const BIRTH          = "birth";
    public const PROFILE        = "profile";
    public const USERNAME       = "username";
    public const EMAIL          = "email";
    public const PASSWORD       = "password";
    public const IS_VERIFIED    = "is_verified";
    public const IS_DELETED     = "is_deleted";
    public const CREATED_AT     = "created_at";
    public const UPDATED_AT     = "updated_at";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: "string", length: 1, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(type: "date", nullable: true)]
    private ?DateTime $birth = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $profile = null;

    #[ORM\Column(type: "string", length: 16, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: "boolean")]
    private bool $isVerified = false;

    #[ORM\Column(type: "boolean")]
    private bool $isDeleted = false;

    // getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function getBirth(): ?DateTime
    {
        return $this->birth;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    // setters
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;
        return $this;
    }

    public function setBirth(?DateTime $birth): self
    {
        $this->birth = $birth;
        return $this;
    }

    public function setProfile(?string $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }
}
