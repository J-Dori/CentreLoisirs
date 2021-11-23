<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields = {"email"}, message="Il y a déjà un Utilisateur avec cet email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     message="Seuls les chiffres sont autorisés dans ce champ")
     */
    private $phoneMob;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = mb_strtoupper($lname);

        return $this;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = ucfirst($fname);

        return $this;
    }

    public function getPhoneMob(): ?string
    {
        $output = str_split($this->phoneMob, 2);
        return implode(" ", $output);
    }

    public function setPhoneMob(?string $phoneMob): self
    {
        $trim = str_replace(' ', '', $phoneMob);
        $dots = str_replace('.', '', $trim);
        $this->phoneMob = $dots;

        return $this;
    }


    public function __toString()
    {
        return ucfirst($this->fname) ." ". mb_strtoupper($this->lname);
    }

    public function getRolesStr()
    {
        $roles = $this->getRoles();
        foreach ($roles as $value) {
            if ($value == 'ROLE_ADMIN')
                return 'Administrateur';
            if ($value == 'ROLE_USER')
                return 'Utilisateur';
        }
        
        return "";
    }

    public function hasRoleAdmin()
    {
        $roles = $this->getRoles();
        foreach ($roles as $value) {
            if ($value == 'ROLE_ADMIN')
                return true;
        }
        
        return false;
    }

}
