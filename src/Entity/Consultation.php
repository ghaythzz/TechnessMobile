<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("consultations")]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    #[Groups("consultations")]
    private ?string $date = null;



    #[ORM\Column(length: 255)]
    #[Groups("consultations")]
    private ?string $comment = null;

    #[ORM\Column(length: 255)]
    #[Groups("consultations")]
    private ?string $medecin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getMedecin(): ?string
    {
        return $this->medecin;
    }

    public function setMedecin(string $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }
}
