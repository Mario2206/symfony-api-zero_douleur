<?php

namespace App\Entity;

use App\Repository\CustomerFeelingsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Range(
     *      min=0,
     *      max=10,
     *      notInRangeMessage="The feeling notation must be between {{ min }} and {{ max }}"
     * )
     * @Assert\NotBlank(message="The pre-notation can't be blank")
     */
    private $preNotation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customerFeelings")
     */
    private $userId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min=0,
     *      max=10,
     *      notInRangeMessage="The feeling notation must be between {{ min }} and {{ max }}"
     * )
     */
    private $postNotation;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     */
    private $postReview;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * 
     * @ORM\Column(type="integer")
     * 
     */
    private $sessionId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishAt;

    public function __construct()
    {
        $this->beginAt = new DateTime();
    }

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

    public function getPostNotation(): ?int
    {
        return $this->postNotation;
    }

    public function setPostNotation(?int $postNotation): self
    {
        $this->postNotation = $postNotation;

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

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getSessionId(): ?int
    {
        return $this->sessionId;
    }

    public function setSessionId(int $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getFinishAt(): ?\DateTimeInterface
    {
        return $this->finishAt;
    }

    public function setFinishAt(?\DateTimeInterface $finishAt): self
    {
        $this->finishAt = $finishAt;

        return $this;
    }
}
