<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\PanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanRepository::class)]
class Pan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("pan")]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("pan")]

    private ?string $totalprix = null;

    #[ORM\Column(length: 255)]
    #[Groups("pan")]
    private ?string $nom = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    

    public function getTotalprix(): ?string
    {
        return $this->totalprix;
    }

    public function setTotalprix(string $totalprix): self
    {
        $this->totalprix = $totalprix;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom( $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
