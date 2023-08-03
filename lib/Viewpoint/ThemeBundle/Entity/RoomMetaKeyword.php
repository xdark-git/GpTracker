<?php

namespace Viewpoint\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Viewpoint\ThemeBundle\Repository\RoomMetaKeywordRepository;

#[ORM\Entity(repositoryClass: RoomMetaKeywordRepository::class)]
class RoomMetaKeyword
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type("string"),
            new Assert\Length(max: 255),
        ])
    ]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\Sequentially([
            new Assert\NotBlank(allowNull: true),
            new Assert\Type("string"),
            new Assert\Length(max: 255),
        ])
    ]
    private ?string $keywords = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }
}
