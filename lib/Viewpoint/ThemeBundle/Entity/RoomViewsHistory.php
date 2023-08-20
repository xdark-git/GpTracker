<?php

namespace Viewpoint\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Viewpoint\AdminBundle\Entity\User;
use Viewpoint\ThemeBundle\Repository\RoomViewsHistoryRepository;

#[ORM\Entity(repositoryClass: RoomViewsHistoryRepository::class)]
class RoomViewsHistory
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime")]
    private \DateTime $lastTimeVisited;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'roomVisited')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Room::class, inversedBy: 'viewsHistory')]
    #[ORM\JoinColumn(nullable: false)]
    private Room $room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastTimeVisited(): \DateTime
    {
        return $this->lastTimeVisited;
    }

    public function setLastTimeVisited(\DateTime $lastTimeVisited): self
    {
        $this->lastTimeVisited = $lastTimeVisited;
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

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): self
    {
        $this->room = $room;
        return $this;
    }
}
