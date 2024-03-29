<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Title shouldn't be blank")
     * @Assert\Length(
     *          min=2, 
     *          max=100,
     *          minMessage="Title must be at least {{ limit }} characters long",
     *          maxMessage="Title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Description shouldn't be blank")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Tags shouldn't be blank")
     */
    private $tag;

    /**
     * @ORM\Column(type="text")
     * 
     */
    private $filename;

    /**
     * @Assert\File(
     *      maxSize="100m",
     *      mimeTypes={"audio/mpeg","video/mp4"},
     *      mimeTypesMessage = "Please upload a valid audio file (like mp3 or mp4)"
     * )
     */
    private $mediaFile;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $uploadedAt;


    public function __construct()
    {
        $this->uploadedAt = new DateTime();
        $this->customerFeelings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTag(): ?string
    {
        return preg_replace('/_/', ' ', $this->tag);
    }

    public function setTag(string $tag): self
    {
        $this->tag = preg_replace('/\s+/', '_', $tag);

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

    /**
     * Set file
     * 
     * @param UploadedFile
     */
    public function setMediaFile(UploadedFile $file = null) : void
    {
        $this->mediaFile = $file;
    }

    /**
     * Get file
     * 
     * @return UploadedFile
     */
    public function getMediaFile () : ?UploadedFile
    {
        return $this->mediaFile;
    }

   
}
