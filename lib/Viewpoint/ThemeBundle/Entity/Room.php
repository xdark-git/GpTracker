<?php

namespace Viewpoint\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Viewpoint\ThemeBundle\Repository\RoomRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[
        Assert\Sequentially([
            new Assert\NotNull(),
            new Assert\Type("string"),
            new Assert\Length(max: 15, min: 5),
        ])
    ]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, unique: true, length: 255)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Length(max: 250),
            new Assert\Regex(
                pattern: "/^[a-z0-9-_]+$/",
                message: "La valeur {{ value }} n'est pas valide."
            ),
        ])
    ]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DECIMAL)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\Type("float")])]
    private ?float $unitPrice = null;

    #[ORM\Column(type: Types::DECIMAL)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\Type("float")])]
    private ?float $weight = null;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}
