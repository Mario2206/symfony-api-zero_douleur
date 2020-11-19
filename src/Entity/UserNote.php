<?php

namespace App\Entity;

use App\Repository\UserNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserNoteRepository::class)
 */
class UserNote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="smallint")
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentReview;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getContentReview(): ?string
    {
        return $this->contentReview;
    }

    public function setContentReview(?string $contentReview): self
    {
        $this->contentReview = $contentReview;

        return $this;
    }
}
