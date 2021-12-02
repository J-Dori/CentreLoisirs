<?php

namespace App\Entity;

use App\Repository\InscriptionDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionDetailRepository::class)
 */
class InscriptionDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $withMeal = false;

    /**
     * @ORM\ManyToOne(targetEntity=Week::class, inversedBy="inscriptionDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $week;

    /**
     * @ORM\ManyToOne(targetEntity=AgeGroup::class, inversedBy="inscriptionDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $AgeGroup;

    /**
     * @ORM\ManyToOne(targetEntity=Children::class, inversedBy="inscriptionDetails")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OrderBy({"fname" = "ASC", "lname" = "ASC"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity=Inscription::class, inversedBy="inscriptionDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inscription;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="inscriptionDetails")
     */
    private $year;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWithMeal(): ?bool
    {
        return $this->withMeal;
    }

    public function setWithMeal(bool $withMeal): self
    {
        $this->withMeal = $withMeal;

        return $this;
    }

    public function getWeek(): ?Week
    {
        return $this->week;
    }

    public function setWeek(?Week $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getAgeGroup(): ?AgeGroup
    {
        return $this->AgeGroup;
    }

    public function setAgeGroup(?AgeGroup $AgeGroup): self
    {
        $this->AgeGroup = $AgeGroup;

        return $this;
    }

    public function getChildren(): ?Children
    {
        return $this->children;
    }

    public function setChildren(?Children $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

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

}
