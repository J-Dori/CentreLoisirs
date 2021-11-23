<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\WeekRepository;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=WeekRepository::class)
 */
class Week
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $weekNum;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $theme;

    /**
     * @ORM\Column(type="date")
     * @ORM\OrderBy({"dateStart" = "ASC"})
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     * @Assert\Expression(
     *     "this.getDateStart() < this.getDateEnd()",
     *     message="La Date de Fin ne doit pas être inférieure à la Date de Début")
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $weekType;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="weeks")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=InscriptionDetail::class, mappedBy="week", orphanRemoval=true)
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

    public function getWeekNum(): ?int
    {
        return $this->weekNum;
    }

    public function setWeekNum(int $weekNum): self
    {
        $this->weekNum = $weekNum;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getWeekType(): ?string
    {
        return $this->weekType;
    }

    public function setWeekType(string $weekType): self
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
            $inscriptionDetail->setWeek($this);
        }

        return $this;
    }

    public function removeInscriptionDetail(InscriptionDetail $inscriptionDetail): self
    {
        if ($this->inscriptionDetails->removeElement($inscriptionDetail)) {
            // set the owning side to null (unless already changed)
            if ($inscriptionDetail->getWeek() === $this) {
                $inscriptionDetail->setWeek(null);
            }
        }

        return $this;
    }
}
