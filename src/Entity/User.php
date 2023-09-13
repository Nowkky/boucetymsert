<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet adresse mail !')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $Lastname = null;

    #[ORM\Column(length: 4)]
    private ?string $Civility = null;

    #[ORM\Column(nullable: true)]
    private ?int $Phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Society = null;

    #[ORM\Column(nullable: true)]
    private ?int $Postal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $City = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ProfilImage = "default_profile_pic.png";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(?string $Firstname): static
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): static
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->Civility;
    }

    public function setCivility(string $Civility): static
    {
        $this->Civility = $Civility;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->Phone;
    }

    public function setPhone(?int $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getSociety(): ?string
    {
        return $this->Society;
    }

    public function setSociety(?string $Society): static
    {
        $this->Society = $Society;

        return $this;
    }

    public function getPostal(): ?int
    {
        return $this->Postal;
    }

    public function setPostal(?int $Postal): static
    {
        $this->Postal = $Postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(?string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getProfilImage(): ?string
    {
        return $this->ProfilImage;
    }

    public function setProfilImage(?string $ProfilImage): static
    {
        $this->ProfilImage = $ProfilImage;

        return $this;
    }
}
