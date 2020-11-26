<?php

namespace App\Entity;

use App\Repository\ContentVideoRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentVideoRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contentTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $contentDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $contentCategory;

    /**
     * @ORM\Column(type="text")
     */
    private $contentTags;

    /**
     * @ORM\Column(type="text")
     */
    private $filename;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadedAt;

    public function __construct()
    {
        $this->uploadedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentTitle(): ?string
    {
        return $this->contentTitle;
    }

    public function setContentTitle(string $contentTitle): self
    {
        $this->contentTitle = $contentTitle;

        return $this;
    }

    public function getContentDescription(): ?string
    {
        return $this->contentDescription;
    }

    public function setContentDescription(string $contentDescription): self
    {
        $this->contentDescription = $contentDescription;

        return $this;
    }

    public function getContentCategory(): ?string
    {
        return $this->contentCategory;
    }

    public function setContentCategory(string $contentCategory): self
    {
        $this->contentCategory = $contentCategory;

        return $this;
    }

    public function getContentTags(): ?string
    {
        return $this->contentTags;
    }

    public function setContentTags(string $contentTags): self
    {
        $this->contentTags = $contentTags;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeInterface $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }
}
