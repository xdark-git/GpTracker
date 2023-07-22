<?php

namespace Viewpoint\AdminBundle\Entity;

use Viewpoint\AdminBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Viewpoint\AdminBundle\Validator as AdminAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('username', message:'Le nom d\'utilisateur {{ value }} existe déjà')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type("string"),
            new Assert\Length(min: 3, max: 50),
            new Assert\Regex(pattern: "/^\D+$/", message: "Votre prénom ne peut pas contenir de chiffre."),
        ])
    ]
    private ?string $firstName = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type("string"),
            new Assert\Length(min: 3, max: 50),
            new Assert\Regex(pattern: "/^\D+$/", message: "Votre nom ne peut pas contenir de chiffre."),
        ])
    ]
    private ?string $lastName = null;

    #[ORM\Column(type: "string", length: 1, nullable: true)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type("string"),
            new Assert\Length(max: 1),
            new Assert\Choice(callback: "getSexes", message: "Veuillez choisir un type de sexe valide."),
        ])
    ]
    private ?string $sexe = null;

    #[ORM\Column(type: "date", nullable: true)]
    #[Assert\Sequentially([new Assert\NotBlank(allowNull: true), new Assert\DateTime()])]
    private ?\DateTime $birth = null;

    #[ORM\Column(type: "string", length: "255", nullable: true)]
    #[Assert\Sequentially([new Assert\NotBlank(allowNull: true), new Assert\Type("string")])]
    private ?string $profile = null;

    #[ORM\Column(type: "string", length: "16", unique: true)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(min: 5, max: 16),
            new Assert\Regex(
                pattern: '/^(?![0-9]+$)[a-zA-Z0-9_-]{5,16}$/',
                message: "Invalid username format."
            ),
        ])
    ]
    private string $username;

    #[ORM\Column(length: 180)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\Email()])]
    #[AdminAssert\UniqueEmail(mode: 'loose')]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;
    
    #[ORM\Column(type: 'boolean')]
    private ?bool $isVerified = false;
    
    #[ORM\Column(type: 'boolean')]
    private ?bool $isDeleted = false;

    #[ManyToOne(targetEntity: Role::class, inversedBy: "users")]
    #[JoinColumn(nullable: false)]
    private Role $role;

    #[ORM\OneToOne(targetEntity: EmailVerificationAttempt::class, mappedBy: 'user')]
    private ?EmailVerificationAttempt $emailVerificationAttempt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;
        return $this;
    }

    public function getBirth(): ?\DateTime
    {
        return $this->birth;
    }

    public function setBirth(?\DateTime $birth): self
    {
        $this->birth = $birth;
        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(?string $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];
        // guarantee every user at least has ROLE_USER
        $roles[] = "ROLE_USER";

        if ($this->role instanceof Role) {
            $roles[] = $this->role->getName();
        }

        return array_unique($roles);
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


    public function getEmailVerificationAttempt(): ?EmailVerificationAttempt
    {
        return $this->emailVerificationAttempt;
    }

    public function setEmailVerificationAttempt(EmailVerificationAttempt $emailVerificationAttempt): self
    {
        $this->emailVerificationAttempt = $emailVerificationAttempt;
        
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public static function getSexes(): array
    {
        return ["M", "F"];
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }
}
