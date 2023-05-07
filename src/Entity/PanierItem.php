<?php

namespace App\Entity;

use App\Repository\PanierItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierItemRepository::class)]
class PanierItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable:true)]
    private ?int $quantite = null;

    #[ORM\Column(nullable:true)]
    private ?int $totale = null;

    #[ORM\ManyToOne(inversedBy: 'idmed')]
    private ?Medicament $medicament = null;

    #[ORM\ManyToOne(inversedBy: 'idpan')]
    private ?Panier $panier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    

    public function getTotale(): ?int
    {
        return $this->totale;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
    public function setTotale(int $totale): self
    {
        $this->totale = $totale;

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

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        $this->panier = $panier;

        return $this;
    }
}
