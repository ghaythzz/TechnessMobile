<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Evenement::class)]
    private Collection $event;

    public function __construct()
    {
        $this->event = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Evenement $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event->add($event);
            $event->setType($this);
        }

        return $this;
    }

    public function removeEvent(Evenement $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getType() === $this) {
                $event->setType(null);
            }
        }

        return $this;
    }
    public function __toString(): string{
        return $this->nom;
    }
}
