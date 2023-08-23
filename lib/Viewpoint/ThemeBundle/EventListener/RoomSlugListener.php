<?php

namespace Viewpoint\ThemeBundle\EventListener;

use Viewpoint\ThemeBundle\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, method: "prePersist", entity: Room::class)]
#[AsEntityListener(event: Events::preUpdate, method: "preUpdate", entity: Room::class)]
class RoomSlugListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger
    ) {
    }

    public function prePersist(Room $room, PrePersistEventArgs $event): void
    {
        $baseSlug = $this->generateBaseSlug($room);
        $uniqueSlug = $this->generateUniqueSlug($baseSlug);

        $room->setSlug($uniqueSlug);
    }

    public function preUpdate(Room $room, PreUpdateEventArgs $event): void
    {
        if (
            $event->hasChangedField("name") ||
            $event->hasChangedField("departureLocation") ||
            $event->hasChangedField("arrivalLocation")
        ) {
            // dd(true);
            $baseSlug = $this->generateBaseSlug($room);
            $uniqueSlug = $this->generateUniqueSlug($baseSlug);

            $room->setSlug($uniqueSlug);
        }
    }

    private function generateBaseSlug(Room $room): string
    {
        $prefix = "gp";
        $slugParts = [
            $prefix,
            $room->getDepartureLocation()->getName(),
            $room->getArrivalLocation()->getName(),
            $room->getName(),
        ];

        $baseSlug = implode("-", $slugParts);

        return $this->slugger
            ->slug($baseSlug)
            ->lower()
            ->toString();
    }

    private function generateUniqueSlug(string $baseSlug): string
    {
        $uniqueIdentifier = uniqid();
        $slug = $baseSlug."-".$uniqueIdentifier;
        // $counter = 1;

        // while ($this->isSlugTaken($slug)) {
        //     $slug = $baseSlug . "-" . $counter;
        //     $counter++;
        // }

        return $slug;
    }

    private function isSlugTaken(string $slug): bool
    {
        $existingRoom = $this->entityManager
            ->getRepository(Room::class)
            ->findOneBy(["slug" => $slug]);

        return $existingRoom !== null;
    }
}
