<?php

namespace App\Entity;

use App\Repository\AgeGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgeGroupRepository::class)
 */
class AgeGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $ageGroup;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="ageGroups")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=InscriptionDetail::class, mappedBy="AgeGroup", orphanRemoval=true)
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

    public function getAgeGroup(): ?string
    {
        return $this->ageGroup;
    }

    public function setAgeGroup(string $ageGroup): self
    {
        $this->ageGroup = $ageGroup;

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
            $inscriptionDetail->setAgeGroup($this);
        }

        return $this;
    }

    public function removeInscriptionDetail(InscriptionDetail $inscriptionDetail): self
    {
        if ($this->inscriptionDetails->removeElement($inscriptionDetail)) {
            // set the owning side to null (unless already changed)
            if ($inscriptionDetail->getAgeGroup() === $this) {
                $inscriptionDetail->setAgeGroup(null);
            }
        }

        return $this;
    }

}
