<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ResponsableRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ResponsableRepository::class)
 */
class Responsable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $relation;

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
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     message="Seuls les chiffres sont autorisés dans ce champ")
     */
    private $phoneMob;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     message="Seuls les chiffres sont autorisés dans ce champ")
     */
    private $phoneHome;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $workName;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     message="Seuls les chiffres sont autorisés dans ce champ")
     */
    private $workPhone;

    /**
     * @ORM\ManyToMany(targetEntity=Children::class, inversedBy="responsables")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="responsable", orphanRemoval=true)
     */
    private $inscriptions;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return ucfirst($this->title);
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = mb_strtoupper($city);

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneMob(): ?string
    {
        $output = str_split($this->phoneMob, 2);
        return implode(" ", $output);
    }

    public function setPhoneMob(?string $phoneMob): self
    {
        $code = str_replace('+', '00', $phoneMob);
        $trim = str_replace(' ', '', $code);
        $dots = str_replace('.', '', $trim);
        $this->phoneMob = $dots;

        return $this;
    }

    public function getPhoneHome(): ?string
    {
        $output = str_split($this->phoneHome, 2);
        return implode(" ", $output);
    }

    public function setPhoneHome(?string $phoneHome): self
    {
        $code = str_replace('+', '00', $phoneHome);
        $trim = str_replace(' ', '', $code);
        $dots = str_replace('.', '', $trim);
        $this->phoneHome = $dots;

        return $this;
    }

    public function getWorkName(): ?string
    {
        return $this->workName;
    }

    public function setWorkName(?string $workName): self
    {
        $this->workName = $workName;

        return $this;
    }

    public function getWorkPhone(): ?string
    {
        $output = str_split($this->workPhone, 2);
        return implode(" ", $output);
    }

    public function setWorkPhone(?string $workPhone): self
    {
        $code = str_replace('+', '00', $workPhone);
        $trim = str_replace(' ', '', $code);
        $dots = str_replace('.', '', $trim);
        $this->workPhone = $dots;

        return $this;
    }


    /**
     * @return Collection|Children[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Children $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
        }

        return $this;
    }

    public function removeChild(Children $child): self
    {
        $this->children->removeElement($child);

        return $this;
    }



    public function __toString()
    {
        return $this->title ." ". ucfirst($this->fname) ." ". mb_strtoupper($this->lname);
    }

    public function fullAddress()
    {
        return $this->address ." | ". $this->cp ." ". $this->city;
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
            $inscription->setResponsable($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getResponsable() === $this) {
                $inscription->setResponsable(null);
            }
        }

        return $this;
    }

}
