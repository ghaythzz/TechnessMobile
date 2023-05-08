<?php

namespace App\Entity;

use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("ordonnances")]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("ordonnances")]
    #[Assert\NotBlank(message:"nom de medecin est obligatoire")]
    private ?string $nomMedecin = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Groups("ordonnances")]
    #[Assert\NotBlank(message:"nom de patient est obligatoire")]
    private ?string $nomPatient = null;

    #[ORM\Column(type: Types::DATE_MUTABLE,nullable: true)]
    #[Groups("ordonnances")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT,nullable: true)]
    #[Groups("ordonnances")]
    #[Assert\NotBlank(message:"commentaire est obligatoire")]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnances')]
    #[Groups("ordonnances")]
    private ?User $doctor = null;

    #[ORM\ManyToOne(inversedBy: 'ordPatients')]
    #[Groups("ordonnances")]
    private ?User $patient = null;

    #[ORM\OneToMany(mappedBy: 'ordonnance', targetEntity: OrdonnanceMedicament::class, cascade: ['persist','remove'])]
    private Collection $ordonnanceMedicaments;

    #[ORM\OneToOne(inversedBy: 'ordonnance')]
    private ?Reservation $reservations = null;




    public function __construct()
    {
        $this->medicaments = new ArrayCollection();
        $this->ordonnanceMedicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMedecin(): ?string
    {
        return $this->nomMedecin;
    }

    public function setNomMedecin(string $nomMedecin): self
    {
        $this->nomMedecin = $nomMedecin;

        return $this;
    }

    public function getNomPatient(): ?string
    {
        return $this->nomPatient;
    }

    public function setNomPatient(string $nomPatient): self
    {
        $this->nomPatient = $nomPatient;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    public function getDoctorId(): ?int
    {
        return $this->doctor ? $this->doctor->getId() : null;
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

    public function getPatientId(): ?int
    {
        return $this->patient ? $this->patient->getId() : null;
    }


    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return Collection<int, OrdonnanceMedicament>
     */
    public function getOrdonnanceMedicaments(): Collection
    {
        return $this->ordonnanceMedicaments;
    }

    public function addOrdonnanceMedicament(OrdonnanceMedicament $ordonnanceMedicament): self
    {
        if (!$this->ordonnanceMedicaments->contains($ordonnanceMedicament)) {
            $this->ordonnanceMedicaments->add($ordonnanceMedicament);
            $ordonnanceMedicament->setOrdonnance($this);
        }

        return $this;
    }

    public function removeOrdonnanceMedicament(OrdonnanceMedicament $ordonnanceMedicament): self
    {
        if ($this->ordonnanceMedicaments->removeElement($ordonnanceMedicament)) {
            // set the owning side to null (unless already changed)
            if ($ordonnanceMedicament->getOrdonnance() === $this) {
                $ordonnanceMedicament->setOrdonnance(null);
            }
        }

        return $this;
    }

    public function getReservations(): ?Reservation
    {
        return $this->reservations;
    }

    public function setReservations(?Reservation $reservations): self
    {
        $this->reservations = $reservations;

        return $this;
    }



}
