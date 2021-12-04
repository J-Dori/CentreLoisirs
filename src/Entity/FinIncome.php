<?php

namespace App\Entity;

use App\Repository\FinIncomeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FinIncomeRepository::class)
 */
class FinIncome
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
    private $numInc;

    /**
     * @ORM\Column(type="date")
     */
    private $dateIn;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $payMode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $docNum;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=FinCategory::class, inversedBy="finIncomes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="finIncomes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumInc(): ?int
    {
        return $this->numInc;
    }

    public function setNumInc(int $numInc): self
    {
        $this->numInc = $numInc;

        return $this;
    }

    public function getDateIn(): ?\DateTimeInterface
    {
        return $this->dateIn;
    }

    public function setDateIn(\DateTimeInterface $dateIn): self
    {
        $this->dateIn = $dateIn;

        return $this;
    }

    public function getPayMode(): ?string
    {
        return $this->payMode;
    }

    public function setPayMode(string $payMode): self
    {
        $this->payMode = $payMode;

        return $this;
    }

    public function getDocNum(): ?string
    {
        return $this->docNum;
    }

    public function setDocNum(?string $docNum): self
    {
        $this->docNum = $docNum;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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

    public function getCategory(): ?FinCategory
    {
        return $this->category;
    }

    public function setCategory(?FinCategory $category): self
    {
        $this->category = $category;

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
