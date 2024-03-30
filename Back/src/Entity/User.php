<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'user:list'])]
    private ?int $id = null;

    #[Groups(['user:read', 'user:list', 'user:write'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:list','user:write'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:read', 'user:list', 'user:write'])]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: MyFile::class)]
    private Collection $ownedFiles;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Directory::class)]
    private Collection $ownedDirectories;

    public function __construct()
    {
        $this->ownedFiles = new ArrayCollection();
        $this->ownedDirectories = new ArrayCollection();
    }

    // #[ORM\Column(length: 255)]
    // #[Groups(['user:read', 'user:list', 'user:write'])]
    // private ?string $plainPassword = null;

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

    // public function getPlainPassword(): ?string
    // {
    //     return $this->plainPassword;
    // }

    // public function setPlainPassword(string $plainPassword): static
    // {
    //     $this->plainPassword = $plainPassword;

    //     return $this;
    // }

    /**
     * @return Collection<int, MyFile>
     */
    public function getOwnedFiles(): Collection
    {
        return $this->ownedFiles;
    }

    public function addOwnedFile(MyFile $ownedFile): static
    {
        if (!$this->ownedFiles->contains($ownedFile)) {
            $this->ownedFiles->add($ownedFile);
            $ownedFile->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedFile(MyFile $ownedFile): static
    {
        if ($this->ownedFiles->removeElement($ownedFile)) {
            // set the owning side to null (unless already changed)
            if ($ownedFile->getOwner() === $this) {
                $ownedFile->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Directory>
     */
    public function getOwnedDirectories(): Collection
    {
        return $this->ownedDirectories;
    }

    public function addOwnedDirectory(Directory $ownedDirectory): static
    {
        if (!$this->ownedDirectories->contains($ownedDirectory)) {
            $this->ownedDirectories->add($ownedDirectory);
            $ownedDirectory->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedDirectory(Directory $ownedDirectory): static
    {
        if ($this->ownedDirectories->removeElement($ownedDirectory)) {
            // set the owning side to null (unless already changed)
            if ($ownedDirectory->getOwner() === $this) {
                $ownedDirectory->setOwner(null);
            }
        }

        return $this;
    }
}
