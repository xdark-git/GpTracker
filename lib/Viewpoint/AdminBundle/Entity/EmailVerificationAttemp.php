<?php

namespace Viewpoint\AdminBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Viewpoint\AdminBundle\Repository\EmailVerificationAttempRepository;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(EmailVerificationAttempRepository::class)]
class EmailVerificationAttemp
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\DateTime()])]
    private ?DateTime $lastResendTime = null;

    #[OneToOne(targetEntity: User::class, mappedBy: 'emailVerificationAttempt')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[Assert\Sequentially([new Assert\NotBlank()])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastResendTime(): ?DateTime
    {
        return $this->lastResendTime;
    }

    public function setLastResendTime(DateTime $lastResendTime): self
    {
        $this->lastResendTime = $lastResendTime;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        
        return $this;
    }
}