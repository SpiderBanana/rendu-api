<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['traitement:read']],
    denormalizationContext: ['groups' => ['traitement:write']]
)]
class Traitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['traitement:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['traitement:read', 'traitement:write'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['traitement:read', 'traitement:write'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['traitement:read', 'traitement:write'])]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['traitement:read', 'traitement:write'])]
    private ?int $duree = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;
        return $this;
    }
}
