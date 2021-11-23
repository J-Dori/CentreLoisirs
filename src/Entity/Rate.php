<?php

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RateRepository::class)
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $child1;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $child2;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $child3;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $child4;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $child5;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="rates")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="rate")
     */
    private $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
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

    public function getChild1(): ?float
    {
        return $this->child1;
    }

    public function setChild1(?float $child1): self
    {
        $this->child1 = $child1;

        return $this;
    }

    public function getChild2(): ?float
    {
        return $this->child2;
    }

    public function setChild2(?float $child2): self
    {
        $this->child2 = $child2;

        return $this;
    }

    public function getChild3(): ?float
    {
        return $this->child3;
    }

    public function setChild3(?float $child3): self
    {
        $this->child3 = $child3;

        return $this;
    }

    public function getChild4(): ?float
    {
        return $this->child4;
    }

    public function setChild4(?float $child4): self
    {
        $this->child4 = $child4;

        return $this;
    }

    public function getChild5(): ?float
    {
        return $this->child5;
    }

    public function setChild5(?float $child5): self
    {
        $this->child5 = $child5;

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
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setRate($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getRate() === $this) {
                $inscription->setRate(null);
            }
        }

        return $this;
    }
}
