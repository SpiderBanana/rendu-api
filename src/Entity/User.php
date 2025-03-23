<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new \ApiPlatform\Metadata\GetCollection(security: "is_granted('ROLE_DIRECTOR')", securityMessage: "Access Denied"),
        new \ApiPlatform\Metadata\Post(
            processor: \App\State\UserPasswordHasherProcessor::class,
            security: "is_granted('ROLE_DIRECTOR')",
            securityMessage: "Access Denied"
        ),
        new \ApiPlatform\Metadata\Get(
            security: "is_granted('ROLE_DIRECTOR') or object == user",
            securityMessage: "Access Denied"
        ),
        new \ApiPlatform\Metadata\Put(
            processor: \App\State\UserPasswordHasherProcessor::class,
            security: "is_granted('ROLE_DIRECTOR') or object == user",
            securityMessage: "Access Denied"
        ),
        new \ApiPlatform\Metadata\Patch(
            processor: \App\State\UserPasswordHasherProcessor::class,
            security: "is_granted('ROLE_DIRECTOR') or object == user",
            securityMessage: "Access Denied"
        ),
        new \ApiPlatform\Metadata\Delete(
            security: "is_granted('ROLE_DIRECTOR') or object == user",
            securityMessage: "Access Denied"
        )
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    // Propriété non persistée pour le hashage (uniquement en écriture)
    #[Groups(['user:write'])]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

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
     * Un identifiant visuel représentant cet utilisateur.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // garantit que chaque utilisateur a au moins le rôle ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    // Getter et setter pour plainPassword

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * Permet d'effacer les données sensibles.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // Efface la valeur temporaire du plainPassword
        $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }
}
