<?php

namespace Viewpoint\ThemeBundle\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Viewpoint\AdminBundle\Entity\User;
use Viewpoint\ThemeBundle\Entity\City;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Viewpoint\ThemeBundle\Validator as ThemeAssert;
use Viewpoint\ThemeBundle\Repository\RoomRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[ThemeAssert\RoomDates()]
#[ThemeAssert\RoomLocations()]
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
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity: Currency::class, fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    #[ORM\Column(type: Types::DECIMAL, nullable: true)]
    #[Assert\Sequentially([new Assert\NotBlank(allowNull: true), new Assert\Type("float")])]
    private ?float $unitPrice = null;

    #[ORM\Column(type: Types::DECIMAL, nullable: true)]
    #[Assert\Sequentially([new Assert\NotBlank(allowNull: true), new Assert\Type("float")])]
    private ?float $weight = null;

    #[ORM\ManyToOne(targetEntity: City::class, fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $departureLocation = null;

    #[ORM\ManyToOne(targetEntity: City::class, fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $arrivalLocation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Sequentially([new Assert\NotBlank(), new Assert\Type("\DateTimeInterface")])]
    private ?DateTime $departureDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Sequentially([new Assert\NotBlank(allowNull: true), new Assert\Type("\DateTimeInterface")])]
    private ?DateTime $arrivalDate = null;

    #[ORM\Column(type: "boolean")]
    private ?bool $isDeleted = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "rooms", fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Conveyance::class, inversedBy: "rooms", fetch: "EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Conveyance $conveyance = null;

    #[
        ORM\OneToOne(
            targetEntity: RoomCellular::class,
            mappedBy: "room",
            cascade: ["persist"],
            fetch: "EAGER"
        )
    ]
    #[Assert\NotBlank(allowNull: true)]
    private ?RoomCellular $cellular = null;

    #[ORM\ManyToOne(targetEntity: RoomMetaKeyword::class, inversedBy: "rooms")]
    #[Assert\NotBlank(allowNull: true)]
    private ?RoomMetaKeyword $roomMetaKeyword = null;

    #[ORM\OneToMany(targetEntity: RoomViewsHistory::class, mappedBy: "room")]
    #[Assert\NotBlank(allowNull: true)]
    private ?Collection $viewsHistory = null;

    private DateTime $currentDateTime;

    public function __construct()
    {
        $this->viewsHistory = new ArrayCollection();
        
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getDepartureLocation(): ?City
    {
        return $this->departureLocation;
    }

    public function setDepartureLocation(City $departureLocation): self
    {
        $this->departureLocation = $departureLocation;
        return $this;
    }

    public function getArrivalLocation(): ?City
    {
        return $this->arrivalLocation;
    }

    public function setArrivalLocation(City $arrivalLocation): self
    {
        $this->arrivalLocation = $arrivalLocation;
        return $this;
    }

    public function getDepartureDate(): ?DateTime
    {
        return $this->departureDate;
    }

    public function setDepartureDate(DateTime $departureDate): self
    {
        $this->departureDate = $departureDate;
        return $this;
    }

    public function getArrivalDate(): ?DateTime
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?DateTime $arrivalDate): self
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getConveyance(): ?Conveyance
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

    public function setCellular(?RoomCellular $cellular): self
    {
        $this->cellular = $cellular;
        return $this;
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

    public function getViewsHistor(): ?Collection
    {
        return $this->viewsHistory;
    }

    public function getCurrentDateTime(): ?DateTime
    {
        $currentDateTime = new DateTime();
        
        return $this->currentDateTime = $currentDateTime;
    }

}
