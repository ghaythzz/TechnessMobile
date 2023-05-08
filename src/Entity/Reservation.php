<?php


namespace App\Entity;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true)]
    #[Groups(["reservations", "resers"])]
    private ?int $id = null;


      
    

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["reservations", "resers"])]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'reservpat')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["reservations", "resers"])]

    private ?User $patient = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]

    #[Groups(["reservations", "resers"])]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]
    #[Groups("reservations")]
    private ?\DateTimeInterface $end = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Groups("reservations")]
 
    private ?string $Comment = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Fiche $Fiche = null;

    #[ORM\OneToOne(mappedBy: 'reservations', cascade: ['persist', 'remove'])]
    private ?Ordonnance $ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {$this->id = $id;
        return $this ;
    }

    

    

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart($start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd($end): self
    {
        
        $this->end = $end;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(string $Comment): self
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): self
    {
        // unset the owning side of the relation if necessary
        if ($ordonnance === null && $this->ordonnance !== null) {
            $this->ordonnance->setReservations(null);
        }

        // set the owning side of the relation if necessary
        if ($ordonnance !== null && $ordonnance->getReservations() !== $this) {
            $ordonnance->setReservations($this);
        }

        $this->ordonnance = $ordonnance;

        return $this;
    }

    public function getFiche(): ?Fiche
    {
        return $this->Fiche;
    }

    public function setFiche(?Fiche $Fiche): self
    {
        $this->Fiche = $Fiche;

        return $this;
    }
    
}
