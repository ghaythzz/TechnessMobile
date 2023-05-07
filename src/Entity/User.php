<?php

namespace App\Entity;
 use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reset_token = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $licenceNumero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bioDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;
    


    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\ManyToOne(inversedBy: 'medecin',cascade: ['remove'])]
    private ?Speciality $speciality = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Reservation::class)]
    private Collection $reservpat;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\Column(nullable: true)]
    private ?float $rates = null;

    private ?float $progress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $baned = null;

    #[ORM\OneToMany(mappedBy: 'doctor', targetEntity: Ordonnance::class)]
    private Collection $ordonnances;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Ordonnance::class)]
    private Collection $ordPatients;

    #[ORM\OneToMany(mappedBy: 'doctor', targetEntity: Fiche::class)]
    private Collection $ficheDoctors;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Fiche::class)]
    private Collection $fiches;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'doctors')]
    private Collection $patients;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'patients')]
    private Collection $doctors;

    public function __construct()
    {
        $this->speciality = null;
        $this->reservpat = new ArrayCollection();

        //$this->rates = new ArrayCollection();
        $this->ordonnances = new ArrayCollection();
        $this->ordPatients = new ArrayCollection();
        $this->ficheDoctors = new ArrayCollection();
        $this->fiches = new ArrayCollection();
        $this->patients = new ArrayCollection();
        $this->doctors = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(string $resetToken): self
    {
        $this->reset_token = $resetToken;

        return $this;
    }


    public function getLicenceNumero(): ?string
    {
        return $this->licenceNumero;
    }

    public function setLicenceNumero(?string $licenceNumero): self
    {
        $this->licenceNumero = $licenceNumero;

        return $this;
    }

    public function getBioDescription(): ?string
    {
        return $this->bioDescription;
    }

    public function setBioDescription(?string $bioDescription): self
    {
        $this->bioDescription = $bioDescription;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
    public function setImageFile( $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }


 //partie reservation ghayth , stay away 

    
    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setUsers($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUsers() === $this) {
                $reservation->setUsers(null);
            }
        }

        return $this;
    }


    public function __tostring() :string{

        return $this->nom;
        
            }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    
    


    /**
     * @return Collection<int, Reservation>
     */
    public function getReservpat(): Collection
    {
        return $this->reservpat;
    }

    public function addReservpat(Reservation $reservpat): self
    {
        if (!$this->reservpat->contains($reservpat)) {
            $this->reservpat->add($reservpat);
            $reservpat->setPatient($this);
        }

        return $this;
    }

    public function removeReservpat(Reservation $reservpat): self
    {
        if ($this->reservpat->removeElement($reservpat)) {
            // set the owning side to null (unless already changed)
            if ($reservpat->getPatient() === $this) {
                $reservpat->setPatient(null);
            }
        }

        return $this;
    }


    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;
    }

    public function getRates(): ?float
    {
        return $this->rates;
    }

    public function setRates(?float $rates): self
    {
        $this->rates = $rates;

        return $this;
    }


    public function getProgress(): ?float
    {
        return $this->progress;
    }

    public function setProgress(?float $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getBaned(): ?string
    {
        return $this->baned;
    }

    public function setBaned(?string $baned): self
    {
        $this->baned = $baned;

        return $this;
    }
    /**
     * @return Collection<int, Ordonnance>
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): self
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances->add($ordonnance);
            $ordonnance->setDoctor($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): self
    {
        if ($this->ordonnances->removeElement($ordonnance)) {
            // set the owning side to null (unless already changed)
            if ($ordonnance->getDoctor() === $this) {
                $ordonnance->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ordonnance>
     */
    public function getOrdPatients(): Collection
    {
        return $this->ordPatients;
    }

    public function addOrdPatient(Ordonnance $ordPatient): self
    {
        if (!$this->ordPatients->contains($ordPatient)) {
            $this->ordPatients->add($ordPatient);
            $ordPatient->setPatient($this);
        }

        return $this;
    }

    public function removeOrdPatient(Ordonnance $ordPatient): self
    {
        if ($this->ordPatients->removeElement($ordPatient)) {
            // set the owning side to null (unless already changed)
            if ($ordPatient->getPatient() === $this) {
                $ordPatient->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fiche>
     */
    public function getFicheDoctors(): Collection
    {
        return $this->ficheDoctors;
    }

    public function addFicheDoctor(Fiche $ficheDoctor): self
    {
        if (!$this->ficheDoctors->contains($ficheDoctor)) {
            $this->ficheDoctors->add($ficheDoctor);
            $ficheDoctor->setDoctor($this);
        }

        return $this;
    }

    public function removeFicheDoctor(Fiche $ficheDoctor): self
    {
        if ($this->ficheDoctors->removeElement($ficheDoctor)) {
            // set the owning side to null (unless already changed)
            if ($ficheDoctor->getDoctor() === $this) {
                $ficheDoctor->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fiche>
     */
    public function getFiches(): Collection
    {
        return $this->fiches;
    }

    public function addFich(Fiche $fich): self
    {
        if (!$this->fiches->contains($fich)) {
            $this->fiches->add($fich);
            $fich->setPatient($this);
        }

        return $this;
    }

    public function removeFich(Fiche $fich): self
    {
        if ($this->fiches->removeElement($fich)) {
            // set the owning side to null (unless already changed)
            if ($fich->getPatient() === $this) {
                $fich->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(self $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
        }

        return $this;
    }

    public function removePatient(self $patient): self
    {
        $this->patients->removeElement($patient);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDoctors(): Collection
    {
        return $this->doctors;
    }

    public function addDoctor(self $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors->add($doctor);
            $doctor->addPatient($this);
        }

        return $this;
    }

    public function removeDoctor(self $doctor): self
    {
        if ($this->doctors->removeElement($doctor)) {
            $doctor->removePatient($this);
        }

        return $this;
    }

}
