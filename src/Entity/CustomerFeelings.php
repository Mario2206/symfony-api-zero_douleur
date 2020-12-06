<?php

namespace App\Entity;

use App\Repository\CustomerFeelingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerFeelingsRepository::class)
 */
class CustomerFeelings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $preNotation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postFeelings;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="CustomerFeeling")
     */
    private $postReview;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPreNotation(): ?int
    {
        return $this->preNotation;
    }

    public function setPreNotation(int $preNotation): self
    {
        $this->preNotation = $preNotation;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPostFeelings(): ?int
    {
        return $this->postFeelings;
    }

    public function setPostFeelings(?int $postFeelings): self
    {
        $this->postFeelings = $postFeelings;

        return $this;
    }

    public function getPostReview(): ?string
    {
        return $this->postReview;
    }

    public function setPostReview(?string $postReview): self
    {
        $this->postReview = $postReview;

        return $this;
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
}
