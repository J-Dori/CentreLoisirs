<?php

namespace App\Entity;

use App\Repository\ArrayListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArrayListRepository::class)
 */
class ArrayList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $rateTitle = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $typeContract = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $ageGroup = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $weekType = [];

    /**
     * @ORM\OneToOne(targetEntity=Year::class, cascade={"persist", "remove"})
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRateTitle(): ?array
    {
        return $this->rateTitle;
    }

    public function setRateTitle(?array $rateTitle): self
    {
        $this->rateTitle = $rateTitle;

        return $this;
    }

    public function getTypeContract(): ?array
    {
        return $this->typeContract;
    }

    public function setTypeContract(array $typeContract): self
    {
        $this->typeContract = $typeContract;

        return $this;
    }

    public function getAgeGroup(): ?array
    {
        return $this->ageGroup;
    }

    public function setAgeGroup(?array $ageGroup): self
    {
        $this->ageGroup = $ageGroup;

        return $this;
    }

    public function getWeekType(): ?array
    {
        return $this->weekType;
    }

    public function setWeekType(?array $weekType): self
    {
        $this->weekType = $weekType;

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


    public function rateTitleStr() 
    {
        $roles = $this->rateTitle;
        $list = [];
        foreach ($roles as $value) {
            array_push($list, $value);
        }
        sort($list);
        $list = implode(' &rtrif; ', $list);
        return $list;
    }

}
