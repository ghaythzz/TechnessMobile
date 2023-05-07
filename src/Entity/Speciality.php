<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'speciality', targetEntity: User::class)]
    private Collection $medecin;

    public function __construct()
    {
        $this->medecin = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getMedecin(): Collection
    {
        return $this->medecin;
    }

    public function addMedecin(User $medecin): self
    {
        if (!$this->medecin->contains($medecin)) {
            $this->medecin->add($medecin);
            $medecin->setSpeciality($this);
        }

        return $this;
    }

    public function removeMedecin(User $medecin): self
    {
        if ($this->medecin->removeElement($medecin)) {
            // set the owning side to null (unless already changed)
            if ($medecin->getSpeciality() === $this) {
                $medecin->setSpeciality(null);
            }
        }

        return $this;
    }
    public function __toString(): string{
        return $this->nom;
    }
}
