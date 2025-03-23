<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['animal:read']],
    denormalizationContext: ['groups' => ['animal:write']]
)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['animal:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $espece = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['animal:read', 'animal:write'])]
    private ?Media $photo = null;

    #[ORM\ManyToOne]
    #[Groups(['animal:read', 'animal:write'])]
    private ?Client $propriétaire = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(?string $espece): static
    {
        $this->espece = $espece;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getPhoto(): ?Media
    {
        return $this->photo;
    }

    public function setPhoto(?Media $photo): static
    {
        $this->photo = $photo;
        return $this;
    }

    public function getPropriétaire(): ?Client
    {
        return $this->propriétaire;
    }

    public function setPropriétaire(?Client $propriétaire): static
    {
        $this->propriétaire = $propriétaire;
        return $this;
    }
}
