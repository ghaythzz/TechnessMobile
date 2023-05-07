<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\RateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RateRepository::class)]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'You must choose between {{ min }} and {{ max }}  to rate a doctor',
    )]
    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $note = null;
    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $opinion = null;

    #[ORM\ManyToOne(inversedBy: 'rates')]
    private ?User $med = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $makeRate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getOpinion(): ?string
    {
        return $this->opinion;
    }

    public function setOpinion(?string $opinion): self
    {
        $this->opinion = $opinion;

        return $this;
    }

    public function getMed(): ?User
    {
        return $this->med;
    }

    public function setMed(?User $med): self
    {
        $this->med = $med;

        return $this;
    }

    public function getMakeRate(): ?User
    {
        return $this->makeRate;
    }

    public function setMakeRate(?User $makeRate): self
    {
        $this->makeRate = $makeRate;

        return $this;
    }
}
