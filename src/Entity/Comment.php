<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter a name")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter a valid email")
     * @Assert\Email(
     *     message = "The email is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please enter a comment")
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Your comment must be at least 1 character long",
     *      maxMessage = "Your comment cannot be longer than 255 characters",
     *      allowEmptyString = false
     * )
     * @Assert\Regex(
     *      pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",
     *      match=false,
     *      message="please enter a valid email")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="comments")
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="comments")
     */
    private $image;

    public function __construct()
    {
        $this->postedAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->author;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeInterface $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
