<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\EnableAutoMapping]
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'you must reserve one place at least')]
    #[Assert\Regex([
        'pattern' => "/^[0-9]*$/",
        'match' => true,
        'message' => 'please enter a integer',
    ])]
    #[ORM\Column]
    private ?int $numberOfPlaces = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfPlaces(): ?int
    {
        return $this->numberOfPlaces;
    }

    public function setNumberOfPlaces(int $numberOfPlaces): self
    {
        $this->numberOfPlaces = $numberOfPlaces;

        return $this;
    }
}
