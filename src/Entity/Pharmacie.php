<?php

namespace App\Entity;

use App\Repository\PharmacieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;
use DateTimeInterface;





#[ORM\Entity(repositoryClass: PharmacieRepository::class)]
class Pharmacie
{
    
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("pharmacies")]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom est obligatoire")]
    #[Groups("pharmacies")]

    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Adresse est obligatoire")]
    #[Groups("pharmacies")]
    private ?string $Adresse = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message:"Veuiller chosir une date")]
    #[Groups("pharmacies")]
    private ?\DateTimeInterface $Tempo = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message:"Veuiller chosir une date")]
    #[Groups("pharmacies")]
    private ?\DateTimeInterface $tempf = null;

    #[ORM\ManyToMany(targetEntity: Medicament::class, mappedBy: 'id_pharmacie')]
    public Collection $medicaments;

     
    public function __construct()
    {
        $this->medicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }
    public function __toString()
    {
        return $this->Nom;
    }
    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getTempo(): ?\DateTimeInterface
    {
        
        return $this->Tempo;
    }

    public function setTempo($Tempo): self
    {
        if (!$Tempo instanceof DateTimeInterface) {
            // Convertit la chaîne de caractères en objet DateTimeInterface
            $Tempo = new DateTime($Tempo);
        }

        $this->Tempo = $Tempo;
       // $this->Tempo = $Tempo;
        

        return $this;
    }

    public function getTempf(): ?\DateTimeInterface
    {
        return $this->tempf;
    }

    public function setTempf($tempf): self
    {
        if (!$tempf instanceof DateTimeInterface) {
            // Convertit la chaîne de caractères en objet DateTimeInterface
            $tempf = new DateTime($tempf);
        }

        $this->tempf = $tempf;

        return $this;
    }
    

    /**
     * @return Collection<int, Medicament>
     */
    public function getMedicaments(): Collection
    {
        return $this->medicaments;
    }
    

    public function addMedicament(Medicament $medicament): self
    {
        if (!$this->medicaments->contains($medicament)) {
            $this->medicaments->add($medicament);
            $medicament->addIdPharmacie($this);
        }

        return $this;
    }

    public function removeMedicament(Medicament $medicament): self
    {
        if ($this->medicaments->removeElement($medicament)) {
            $medicament->removeIdPharmacie($this);
        }

        return $this;
    }

   
}
