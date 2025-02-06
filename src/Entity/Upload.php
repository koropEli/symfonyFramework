<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UploadRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UploadRepository::class)]
class Upload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['user:read'])]
    private int $firmwareId;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['user:read'])]
    private \DateTimeImmutable $uploadedAt;

    #[ORM\Column(type: 'integer')]
    #[Groups(['user:read'])]
    private int $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFirmwareId(int $firmwareId): self
    {
        $this->firmwareId = $firmwareId;
        return $this;
    }

    public function getFirmwareId(): int
    {
        return $this->firmwareId;
    }

    public function setUploadedAt(\DateTimeImmutable $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;
        return $this;
    }

    public function getUploadedAt(): \DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
