<?php

namespace App\Entity;

use App\Repository\FicheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: FicheRepository::class)]
class Fiche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("fiches")]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups("fiches")]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("fiches")]
    #[Assert\NotBlank(message:"tel est obligatoire")]
    #[Assert\Length(
        exactly: 8,
        exactMessage: 'Tel doit être de longueur 8'
    )]
    private ?int $tel = null;

    #[ORM\OneToMany(mappedBy: 'Fiche', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'ficheDoctors')]
    private ?User $doctor = null;

    #[ORM\ManyToOne(inversedBy: 'fiches')]
    private ?User $patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("fiches")]
    private ?string $etatClinique = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("fiches")]
    private ?string $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("fiches")]
    private ?string $typeAssurance = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance($date_naissance): self
    {
        if(!$date_naissance instanceof DateTimeInterface) {
            $date_naissance = new DateTime($date_naissance);
        }
        $this->date_naissance=$date_naissance;
        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

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
            $reservation->setFiche($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getFiche() === $this) {
                $reservation->setFiche(null);
            }
        }

        return $this;
    }

    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    public function setDoctor(?User $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getEtatClinique(): ?string
    {
        return $this->etatClinique;
    }

    public function setEtatClinique(string $etatClinique): self
    {
        $this->etatClinique = $etatClinique;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getTypeAssurance(): ?string
    {
        return $this->typeAssurance;
    }

    public function setTypeAssurance(string $typeAssurance): self
    {
        $this->typeAssurance = $typeAssurance;

        return $this;
    }
}
