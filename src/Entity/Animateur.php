<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnimateurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnimateurRepository::class)
 
 */
class Animateur
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
     * @ORM\Column(type="string", length=50)
     */
    private $lname;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\OrderBy({"fname" = "ASC", "lname" = "ASC"})
     */
    private $fname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Expression(
     *     "this.birthday() < this.getCurrentDate()",
     *     message="La Date d'anniversaire doit être inférieure à aujourd'hui")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $birthCity;

    /**
     * @ORM\Column(type="string", length=150)
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
     * @ORM\Column(type="string", length=150)
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
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $numSS;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     message="Seuls les chiffres sont autorisés dans ce champ")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=AnimateurContract::class, mappedBy="animateur")
     * @ORM\OrderBy({"year" = "DESC"})
     */
    private $animateurContracts;

    public function __construct()
    {
        $this->animateurContracts = new ArrayCollection();
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

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBirthCity(): ?string
    {
        return $this->birthCity;
    }

    public function setBirthCity(?string $birthCity): self
    {
        $this->birthCity = $birthCity;

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

    public function setEmail(string $email): self
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

    public function getNumSS(): ?string
    {
        return $this->numSS;
    }

    public function setNumSS(?string $numSS): self
    {
        $this->numSS = $numSS;

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
            $animateurContract->setAnimateur($this);
        }

        return $this;
    }

    public function removeAnimateurContract(AnimateurContract $animateurContract): self
    {
        if ($this->animateurContracts->removeElement($animateurContract)) {
            // set the owning side to null (unless already changed)
            if ($animateurContract->getAnimateur() === $this) {
                $animateurContract->setAnimateur(null);
            }
        }

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

}
