<?php

namespace App\Entity;

use App\Repository\AnimateurContractRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimateurContractRepository::class)
 */
class AnimateurContract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typeContract;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="animateur")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Animateur::class, inversedBy="animateurContracts")
     */
    private $animateur;

    /**
     * @ORM\ManyToOne(targetEntity=AgeGroup::class, inversedBy="animateurContracts")
     */
    private $ageGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeContract(): ?string
    {
        return $this->typeContract;
    }

    public function setTypeContract(string $typeContract): self
    {
        $this->typeContract = $typeContract;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

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

    public function getAnimateur(): ?Animateur
    {
        return $this->animateur;
    }

    public function setAnimateur(?Animateur $animateur): self
    {
        $this->animateur = $animateur;

        return $this;
    }

    public function getAgeGroup(): ?AgeGroup
    {
        return $this->ageGroup;
    }

    public function setAgeGroup(?AgeGroup $ageGroup): self
    {
        $this->ageGroup = $ageGroup;

        return $this;
    }
}
