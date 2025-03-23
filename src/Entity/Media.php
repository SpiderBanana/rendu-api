<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => ['media:read']],
    denormalizationContext: ['groups' => ['media:write']]
)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['media:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['media:read'])]
    private ?string $filePath = null;

    // Ce champ permet de recevoir le fichier lors de l'upload (non persisté)
    #[Vich\UploadableField(mapping: 'media_object', fileNameProperty: 'filePath')]
    #[Groups(['media:write'])]
    public ?File $file = null;

    // Ce champ pourra être renseigné lors de la normalisation pour retourner l'URL du fichier
    #[Groups(['media:read'])]
    public ?string $contentUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;
        return $this;
    }
}
