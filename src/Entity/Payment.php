<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datePay;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $modePay;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Inscription::class, inversedBy="payments")
     */
    private $inscription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePay(): ?\DateTimeInterface
    {
        return $this->datePay;
    }

    public function setDatePay(\DateTimeInterface $datePay): self
    {
        $this->datePay = $datePay;

        return $this;
    }

    public function getModePay(): ?string
    {
        return $this->modePay;
    }

    public function setModePay(string $modePay): self
    {
        $this->modePay = $modePay;

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

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }
}
