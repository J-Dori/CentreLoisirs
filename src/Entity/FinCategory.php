<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FinCategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FinCategoryRepository::class)
 * @UniqueEntity(fields = "title", message = "Cette Catégorie existe déjà!")
 */
class FinCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\OrderBy({"title"="ASC"})
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=FinIncome::class, mappedBy="category")
     */
    private $finIncomes;

    /**
     * @ORM\OneToMany(targetEntity=FinExpense::class, mappedBy="category")
     */
    private $finExpenses;

    public function __construct()
    {
        $this->finIncomes = new ArrayCollection();
        $this->finExpenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|FinIncome[]
     */
    public function getFinIncomes(): Collection
    {
        return $this->finIncomes;
    }

    public function addFinIncome(FinIncome $finIncome): self
    {
        if (!$this->finIncomes->contains($finIncome)) {
            $this->finIncomes[] = $finIncome;
            $finIncome->setCategory($this);
        }

        return $this;
    }

    public function removeFinIncome(FinIncome $finIncome): self
    {
        if ($this->finIncomes->removeElement($finIncome)) {
            // set the owning side to null (unless already changed)
            if ($finIncome->getCategory() === $this) {
                $finIncome->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FinExpense[]
     */
    public function getFinExpenses(): Collection
    {
        return $this->finExpenses;
    }

    public function addFinExpense(FinExpense $finExpense): self
    {
        if (!$this->finExpenses->contains($finExpense)) {
            $this->finExpenses[] = $finExpense;
            $finExpense->setCategory($this);
        }

        return $this;
    }

    public function removeFinExpense(FinExpense $finExpense): self
    {
        if ($this->finExpenses->removeElement($finExpense)) {
            // set the owning side to null (unless already changed)
            if ($finExpense->getCategory() === $this) {
                $finExpense->setCategory(null);
            }
        }

        return $this;
    }
}
