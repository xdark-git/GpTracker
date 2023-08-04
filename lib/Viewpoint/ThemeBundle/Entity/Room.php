<?php

namespace Viewpoint\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Viewpoint\ThemeBundle\Repository\RoomRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Viewpoint\AdminBundle\Entity\User;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 15)]
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

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(max: 250),
        ])
    ]
    private ?string $departureLocation = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Type("string"),
            new Assert\Length(max: 250),
        ])
    ]
    private ?string $arrivalLocation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\DateTime()])]
    private ?\DateTime $departureDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\DateTime()])]
    private ?\DateTime $arrivalDate = null;

    #[ORM\Column(type: "boolean")]
    private ?bool $isDeleted = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "rooms")]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Conveyance::class, inversedBy: "rooms")]
    #[ORM\JoinColumn(nullable: false)]
    private Conveyance $conveyance;

    #[ORM\OneToOne(targetEntity: RoomCellular::class, mappedBy: "room")]
    private ?RoomCellular $cellular = null;

    #[ORM\ManyToOne(targetEntity: RoomMetaKeyword::class, inversedBy: "rooms")]
    private ?RoomMetaKeyword $roomMetaKeyword;

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

    public function getDepartureLocation(): ?string
    {
        return $this->departureLocation;
    }

    public function setDepartureLocation(?string $departureLocation): self
    {
        $this->departureLocation = $departureLocation;
        return $this;
    }

    public function getArrivalLocation(): ?string
    {
        return $this->arrivalLocation;
    }

    public function setArrivalLocation(?string $arrivalLocation): self
    {
        $this->arrivalLocation = $arrivalLocation;
        return $this;
    }

    public function getDepartureDate(): ?\DateTime
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTime $departureDate): self
    {
        $this->departureDate = $departureDate;
        return $this;
    }

    public function getArrivalDate(): ?\DateTime
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTime $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getConveyance(): Conveyance
    {
        return $this->conveyance;
    }

    public function setConveyance(Conveyance $conveyance): self
    {
        $this->conveyance = $conveyance;
        return $this;
    }

    public function getCellular(): ?RoomCellular
    {
        return $this->cellular;
    }

    public function getRoomMetaKeyword(): ?RoomMetaKeyword
    {
        return $this->roomMetaKeyword;
    }

    public function setRoomMetaKeyword(?RoomMetaKeyword $roomMetaKeyword): self
    {
        $this->roomMetaKeyword = $roomMetaKeyword;
        return $this;
    }
}
