<?php

namespace App\Entity;

use App\Repository\PanierxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PanierxRepository::class)]
class Panierx
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("paniera")]

    private ?int $id = null;

     #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false,)]
     #[Groups("paniera")]
        /**
         * @ORM\ManyToOne(targetEntity="User")
         * @ORM\JoinColumn(name="id_user_id", referencedColumnName="id_user", onDelete="CASCADE")
         */
    public ?User $id_user = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("paniera")]

    public ?Medicament $id_medica = null;

    #[ORM\Column]
    #[Groups("paniera")]

    public ?int $qte = null;

    #[ORM\Column]
    #[Groups("paniera")]

    public ?float $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser( $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
    

    public function getIdMedica(): ?Medicament
    {
        return $this->id_medica;
    }

    public function setIdMedica(?Medicament $id_medica): self
    {
        $this->id_medica = $id_medica;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
