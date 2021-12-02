<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\YearRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=YearRepository::class)
 */
class Year
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OrderBy({"year" = "DESC"})
     */
    private $year;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceMeal;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceInscription;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $numHabilitation;

    /**
     * @ORM\OneToMany(targetEntity=AnimateurContract::class, mappedBy="year")
     */
    private $animateurContracts;

    /**
     * @ORM\OneToMany(targetEntity=Week::class, mappedBy="year")
     */
    private $weeks;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=AgeGroup::class, mappedBy="year")
     */
    private $ageGroups;

    /**
     * @ORM\OneToMany(targetEntity=Rate::class, mappedBy="year")
     */
    private $rates;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="year", orphanRemoval=true)
     */
    private $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity=InscriptionDetail::class, mappedBy="year", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $inscriptionDetails;

    public function __construct()
    {
        $this->animateurContracts = new ArrayCollection();
        $this->weeks = new ArrayCollection();
        $this->ageGroups = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->inscriptionDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPriceMeal(): ?float
    {
        return $this->priceMeal;
    }

    public function setPriceMeal(?float $priceMeal): self
    {
        $this->priceMeal = $priceMeal;

        return $this;
    }

    public function getPriceInscription(): ?float
    {
        return $this->priceInscription;
    }

    public function setPriceInscription(?float $priceInscription): self
    {
        $this->priceInscription = $priceInscription;

        return $this;
    }

    public function getNumHabilitation(): ?string
    {
        return $this->numHabilitation;
    }

    public function setNumHabilitation(?string $numHabilitation): self
    {
        $this->numHabilitation = $numHabilitation;

        return $this;
    }

    /**
     * @return Collection|AnimateurContract[]
     */
    public function getAnimateurContracts(): Collection
    {
        return $this->animateurContracts;
    }

    public function addAnimateurContract(AnimateurContract $animateurContract): self
    {
        if (!$this->animateurContracts->contains($animateurContract)) {
            $this->animateurContracts[] = $animateurContract;
            $animateurContract->setYear($this);
        }

        return $this;
    }

    public function removeAnimateurContract(AnimateurContract $animateurContract): self
    {
        if ($this->animateurContracts->removeElement($animateurContract)) {
            // set the owning side to null (unless already changed)
            if ($animateurContract->getYear() === $this) {
                $animateurContract->setYear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Week[]
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks[] = $week;
            $week->setYear($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): self
    {
        if ($this->weeks->removeElement($week)) {
            // set the owning side to null (unless already changed)
            if ($week->getYear() === $this) {
                $week->setYear(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Collection|AgeGroup[]
     */
    public function getAgeGroups(): Collection
    {
        return $this->ageGroups;
    }

    public function addAgeGroup(AgeGroup $ageGroup): self
    {
        if (!$this->ageGroups->contains($ageGroup)) {
            $this->ageGroups[] = $ageGroup;
            $ageGroup->setYear($this);
        }

        return $this;
    }

    public function removeAgeGroup(AgeGroup $ageGroup): self
    {
        if ($this->ageGroups->removeElement($ageGroup)) {
            // set the owning side to null (unless already changed)
            if ($ageGroup->getYear() === $this) {
                $ageGroup->setYear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setYear($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getYear() === $this) {
                $rate->setYear(null);
            }
        }

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
            $inscription->setYear($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getYear() === $this) {
                $inscription->setYear(null);
            }
        }

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
            $inscriptionDetail->setYear($this);
        }

        return $this;
    }

    public function removeInscriptionDetail(InscriptionDetail $inscriptionDetail): self
    {
        if ($this->inscriptionDetails->removeElement($inscriptionDetail)) {
            // set the owning side to null (unless already changed)
            if ($inscriptionDetail->getYear() === $this) {
                $inscriptionDetail->setYear(null);
            }
        }

        return $this;
    }
}
