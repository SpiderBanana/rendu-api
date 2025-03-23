<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['rdv:read']],
    denormalizationContext: ['groups' => ['rdv:write']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            security: "is_granted('ROLE_ASSISTANT')",
            securityMessage: "Seuls les assistants vétérinaires peuvent créer un rendez-vous"
        ),
        new Put(
            security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN')",
            securityMessage: "Accès refusé"
        ),
        new Patch(
            security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN')",
            securityMessage: "Accès refusé"
        ),
        new Delete(
            security: "is_granted('ROLE_ASSISTANT')",
            securityMessage: "Seuls les assistants vétérinaires peuvent supprimer un rendez-vous"
        )
    ]
)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['rdv:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['rdv:read'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['rdv:read', 'rdv:write'])]
    private ?\DateTimeInterface $dateRdv = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['rdv:read', 'rdv:write'])]
    private ?string $motif = null;

    #[ORM\ManyToOne]
    #[Groups(['rdv:read', 'rdv:write'])]
    private ?Animal $animal = null;

    #[ORM\ManyToOne]
    #[Groups(['rdv:read', 'rdv:write'])]
    private ?User $assistant = null;

    #[ORM\ManyToOne]
    #[Groups(['rdv:read', 'rdv:write'])]
    private ?User $veterinaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['rdv:read', 'rdv:write'])]
    private ?string $statut = null;

    /**
     * @var Collection<int, Traitement>
     */
    #[ORM\ManyToMany(targetEntity: Traitement::class)]
    #[Groups(['rdv:read', 'rdv:write'])]
    private Collection $traitements;

    public function __construct()
    {
        $this->traitements = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->dateRdv;
    }

    public function setDateRdv(?\DateTimeInterface $dateRdv): static
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        $this->assistant = $assistant;

        return $this;
    }

    public function getVeterinaire(): ?User
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?User $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(Traitement $traitement): static
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements->add($traitement);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): static
    {
        $this->traitements->removeElement($traitement);

        return $this;
    }
}
