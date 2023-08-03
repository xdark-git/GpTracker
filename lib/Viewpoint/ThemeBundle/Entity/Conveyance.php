<?php

namespace Viewpoint\ThemeBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Viewpoint\ThemeBundle\Repository\ConveyanceRepository;

#[ORM\Entity(repositoryClass: ConveyanceRepository::class)]
class Conveyance
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[
        Assert\Sequentially([
            new Assert\NotNull(),
            new Assert\Type("string"),
            new Assert\Length(max: 255),
        ])
    ]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'conveyance')]
    private ?Collection $rooms = null;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

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

    public function getRooms(): ?Collection
    {
        return $this->rooms;
    }
}
