<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChildrenRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChildrenRepository::class)
 */
class Children
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lname;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\OrderBy({"fname" = "ASC", "lname" = "ASC"})
     */
    private $fname;

    /**
     * @ORM\Column(type="date")
     * @Assert\Expression(
     *     "this.birthday() < this.getCurrentDate()",
     *     message="La Date d'anniversaire doit être inférieure à aujourd'hui")
     */
    private $birthday;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $medicalObs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $allergyObs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $foodObs;

    /**
     * @ORM\ManyToMany(targetEntity=Responsable::class, mappedBy="children")
     */
    private $responsables;

    /**
     * @ORM\OneToMany(targetEntity=InscriptionDetail::class, mappedBy="children", orphanRemoval=true)
     */
    private $inscriptionDetails;

    

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
        $this->responsables = new ArrayCollection();
        $this->inscriptionDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getLname(): ?string
    {
        return mb_strtoupper($this->lname);
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getFname(): ?string
    {
        return ucfirst($this->fname);
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getMedicalObs(): ?string
    {
        return $this->medicalObs;
    }

    public function setMedicalObs(?string $medicalObs): self
    {
        $this->medicalObs = $medicalObs;

        return $this;
    }

    public function getAllergyObs(): ?string
    {
        return $this->allergyObs;
    }

    public function setAllergyObs(?string $allergyObs): self
    {
        $this->allergyObs = $allergyObs;

        return $this;
    }

    public function getFoodObs(): ?string
    {
        return $this->foodObs;
    }

    public function setFoodObs(?string $foodObs): self
    {
        $this->foodObs = $foodObs;

        return $this;
    }

    /**
     * @return Collection|Responsable[]
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
            $responsable->addChild($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): self
    {
        if ($this->responsables->removeElement($responsable)) {
            $responsable->removeChild($this);
        }

        return $this;
    }


    public function __toString()
    {
        return ucfirst($this->fname) ." ". mb_strtoupper($this->lname);
    }

    public function getAge()
    {
        if ($this->birthday == null)
            return null;

        $today = new \DateTime;
        $age = $this->birthday->diff($today);
        return $age->format("%y");
    }

    //Assert Expression on $birthday
    public function getCurrentDate(){
        return new \DateTime();
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
            $inscriptionDetail->setChildren($this);
        }

        return $this;
    }

    public function removeInscriptionDetail(InscriptionDetail $inscriptionDetail): self
    {
        if ($this->inscriptionDetails->removeElement($inscriptionDetail)) {
            // set the owning side to null (unless already changed)
            if ($inscriptionDetail->getChildren() === $this) {
                $inscriptionDetail->setChildren(null);
            }
        }

        return $this;
    }

}
