<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numInsc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=Rate::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity=Responsable::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=InscriptionDetail::class, mappedBy="inscription", orphanRemoval=true)
     */
    private $inscriptionDetails;

    public function __construct()
    {
        $this->inscriptionDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumInsc(): ?int
    {
        return $this->numInsc;
    }

    public function setNumInsc(int $numInsc): self
    {
        $this->numInsc = $numInsc;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function setRate(?Rate $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function setResponsable(?Responsable $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getYear(): ?Year
    {
        return $this->year;
    }

    public function setYear(?Year $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|InscriptionDetail[]
     */
    public function getInscriptionDetails(): Collection
    {
        return $this->inscriptionDetails;
    }

    public function addInscriptionDetail(InscriptionDetail $inscriptionDetail): self
    {
        if (!$this->inscriptionDetails->contains($inscriptionDetail)) {
            $this->inscriptionDetails[] = $inscriptionDetail;
            $inscriptionDetail->setInscription($this);
        }

        return $this;
    }

    public function removeInscriptionDetail(InscriptionDetail $inscriptionDetail): self
    {
        if ($this->inscriptionDetails->removeElement($inscriptionDetail)) {
            // set the owning side to null (unless already changed)
            if ($inscriptionDetail->getInscription() === $this) {
                $inscriptionDetail->setInscription(null);
            }
        }

        return $this;
    }
}
