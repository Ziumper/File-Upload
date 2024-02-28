<?php

namespace App\Entity;

use App\Repository\UploadEntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UploadEntryRepository::class)]
class UploadEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 255,  nullable: true)]
    private ?string $imageExtension = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageExtension(): ?string
    {
        return $this->imageExtension;
    }

    public function setImageExtension(string $imageExtension): static
    {
        $this->imageExtension = $imageExtension;

        return $this;
    }
}
