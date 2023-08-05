<?php

namespace Viewpoint\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Viewpoint\ThemeBundle\Repository\RoomCellularRepository;

#[ORM\Entity(repositoryClass: RoomCellularRepository::class)]
class RoomCellular
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:"primary_number", length: 15)]
    #[
        Assert\Sequentially([
            new Assert\NotNull(),
            new Assert\Type("string"),
            new Assert\Length(max: 15, min: 5),
            new Assert\Regex(
                pattern: '/^\+?(?:\d+[-.\s]?)*\d$
                /',
                message: "Le Numéro {{ value }} est invalide"
            ),
        ])
    ]
    private ?string $primary = null;

    #[ORM\Column(name:"secondary_number", length: 15)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type("string"),
            new Assert\Length(max: 15, min: 5),
            new Assert\Regex(
                pattern: '/^\+?(?:\d+[-.\s]?)*\d$
                /',
                message: "Le Numéro {{ value }} est invalide"
            ),
        ])
    ]
    private ?string $secondary = null;

    #[ORM\OneToOne(targetEntity: Room::class, inversedBy: "cellular")]
    #[ORM\JoinColumn(nullable: false)]
    private Room $room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrimary(): ?string
    {
        return $this->primary;
    }

    public function setPrimary(string $primary): self
    {
        $this->primary = str_replace(' ', '', $primary);
        return $this;
    }

    public function getSecondary(): ?string
    {
        return $this->secondary;
    }

    public function setSecondary(string $secondary): self
    {
        $this->secondary = str_replace(' ', '', $secondary);
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
