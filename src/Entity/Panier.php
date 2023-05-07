<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
     

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Datecreation = null;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: PanierItem::class)]
    private Collection $idpan;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $idu = null;

    public function __construct()
    {
        $this->idpan = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->Datecreation;
    }

    public function setDatecreation(\DateTimeInterface $Datecreation): self
    {
        $this->Datecreation = $Datecreation;

        return $this;
    }

    /**
     * @return Collection<int, PanierItem>
     */
    public function getIdpan(): Collection
    {
        return $this->idpan;
    }

    public function addIdpan(PanierItem $idpan): self
    {
        if (!$this->idpan->contains($idpan)) {
            $this->idpan->add($idpan);
            $idpan->setPanier($this);
        }

        return $this;
    }

    public function removeIdpan(PanierItem $idpan): self
    {
        if ($this->idpan->removeElement($idpan)) {
            // set the owning side to null (unless already changed)
            if ($idpan->getPanier() === $this) {
                $idpan->setPanier(null);
            }
        }

        return $this;
    }

    public function getIdu(): ?User
    {
        return $this->idu;
    }

    public function setIdu(?User $idu): self
    {
        $this->idu = $idu;

        return $this;
    }
}
