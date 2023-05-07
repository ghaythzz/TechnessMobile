<?php

namespace App\Entity;

use App\Repository\OrdonnanceMedicamentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OrdonnanceMedicamentRepository::class)]
class OrdonnanceMedicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("meds")]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnanceMedicaments')]
    private ?Ordonnance $ordonnance = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnanceMedicaments')]
    private ?Medicament $medicament = null;

    #[ORM\Column(nullable: true)]
    #[Groups("meds")]
    #[Assert\NotBlank(message:"dosage est obligatoire")]
    #[Assert\LessThan(5 ,message: "less then 5")]
    private ?int $dosage = null;

    #[ORM\Column(nullable: true)]
    #[Groups("meds")]
    #[Assert\NotBlank(message:"duration est obligatoire")]
    private ?int $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): self
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }

    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(?Medicament $medicament): self
    {
        $this->medicament = $medicament;

        return $this;
    }

    public function getDosage(): ?int
    {
        return $this->dosage;
    }

    public function setDosage(?int $dosage): self
    {
        $this->dosage = $dosage;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    public function __toString(): string {
        return $this->dosage.' '.$this->duration;
    }
}
