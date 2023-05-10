<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Ce champ ne doit contenir que des caractères alphabétiques."
     * )
     */
    private ?string $nom_t = null;

    #[ORM\Column]
       /**
     * @Assert\Range(
     *      min = 10,
     *      max = 22,
     *      notInRangeMessage = "Le prix doit être compris entre {{ min }} et {{ max }}.",
     * )   
     */
    private ?int $nb_places = null;

    #[ORM\Column(length: 255)]
       /**
     * @Assert\Range(
     *      min = 100,
     *      max = 1000,
     *      notInRangeMessage = "Le prix doit être compris entre {{ min }} et {{ max }}.",
     * )   
     */
    private ?string $surface = null;

    #[ORM\Column(length: 255)]
    private ?string $type_r = null;

    #[ORM\Column(length: 255)]
    private ?string $type_c = null;

    #[ORM\Column]
       /**
       *  @Assert\NotBlank(message=" le prix doit etre non vide")
      *      pattern = "/^\d+(\.\d{1,2})?$/",
     *      match = true,
     *      message = "Le champ prix doit être un nombre décimal entre 10.00 et 1000.00 avec au maximum 2 décimales."
     * )
     * @Assert\Range(
     *      min = 10,
     *      max = 1000000,
     *      notInRangeMessage = "Le prix doit être compris entre {{ min }} et {{ max }}.",
     * )   
     */
    private ?int $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'terrain', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomT(): ?string
    {
        return $this->nom_t;
    }

    public function setNomT(string $nom_t): self
    {
        $this->nom_t = $nom_t;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nb_places;
    }

    public function setNbPlaces(int $nb_places): self
    {
        $this->nb_places = $nb_places;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getTypeR(): ?string
    {
        return $this->type_r;
    }

    public function setTypeR(string $type_r): self
    {
        $this->type_r = $type_r;

        return $this;
    }

    public function getTypeC(): ?string
    {
        return $this->type_c;
    }

    public function setTypeC(string $type_c): self
    {
        $this->type_c = $type_c;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setTerrain($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getTerrain() === $this) {
                $reservation->setTerrain(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom_t;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
