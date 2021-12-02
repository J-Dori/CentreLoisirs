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
     * @ORM\OneToMany(targetEntity=InscriptionDetail::class, mappedBy="inscription", orphanRemoval=true, cascade={"persist"})
     */
    private $inscriptionDetails;

    /**
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="inscription", orphanRemoval=true)
     */
    private $payments;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalWeek;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qttMeal;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceInsc;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalInsc;


    public function __construct()
    {
        $this->inscriptionDetails = new ArrayCollection();
        $this->payments = new ArrayCollection();
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


    //Get totals of Children and Weeks in Inscription (inscription_index Table)
    public function countChildrenAndWeeks() 
    {
        if ($this->inscriptionDetails->count()) {
            $chilIdList = array();
            $lastId = null;
            foreach ($this->inscriptionDetails as $colection) {
                $id = $colection->getChildren()->getId();
                if ($id != $lastId) { //to not repeat same ID (select Distinct)
                    $chilIdList[] = $colection->getChildren()->getId();
                    $lastId = $colection->getChildren()->getId();
                }
                $weekIdList[] = $colection->getWeek()->getId();
            }
        }
        return count($chilIdList) ." / ". count($weekIdList);
    }
    //END: Get totals of Children and Weeks in Inscription (inscription_index Table)


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


    public function getTotalPaid()
    {
        $total = 0;
        foreach ($this->payments as $key) {
            $total += $key->getAmount();
        }
        return $total;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setInscription($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getInscription() === $this) {
                $payment->setInscription(null);
            }
        }

        return $this;
    }

    public function getQttMeal(): ?int
    {
        return $this->qttMeal;
    }

    public function setQttMeal(?int $qttMeal): self
    {
        $this->qttMeal = $qttMeal;

        return $this;
    }

    public function getPriceInsc(): ?float
    {
        return $this->priceInsc;
    }

    public function setPriceInsc(?float $priceInsc): self
    {
        $this->priceInsc = $priceInsc;

        return $this;
    }

    public function getTotalInsc(): ?float
    {
        return $this->totalInsc;
    }

    public function setTotalInsc(?float $totalInsc): self
    {
        $this->totalInsc = $totalInsc;

        return $this;
    }

    public function getTotalWeek(): ?float
    {
        return $this->totalWeek;
    }

    public function setTotalWeek(?float $totalWeek): self
    {
        $this->totalWeek = $totalWeek;

        return $this;
    }

}
