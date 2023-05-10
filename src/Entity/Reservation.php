<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_r = null;

    #[ORM\Column(length: 255)]
    private ?string $heure_r = null;

    #[ORM\Column]

    private ?int $reserved_places = null;

    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
   
     */
    private ?string $Renseignements = null;

    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     */
    private ?string $user_email = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Terrain $terrain = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateR(): ?\DateTimeInterface
    {
        return $this->date_r;
    }

    public function setDateR(\DateTimeInterface $date_r): self
    {
        $this->date_r = $date_r;

        return $this;
    }

    public function getHeureR(): ?string
    {
        return $this->heure_r;
    }

    public function setHeureR(string $heure_r): self
    {
        $this->heure_r = $heure_r;

        return $this;
    }

    public function getReservedPlaces(): ?int
    {
        return $this->reserved_places;
    }

    public function setReservedPlaces(int $reserved_places): self
    {
        $this->reserved_places = $reserved_places;

        return $this;
    }

    public function getRenseignements(): ?string
    {
        return $this->Renseignements;
    }

    public function setRenseignements(string $Renseignements): self
    {
        $this->Renseignements = $Renseignements;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getTerrain(): ?terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?terrain $terrain): self
    {
        $this->terrain = $terrain;

        return $this;
    }
}
