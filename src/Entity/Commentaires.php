<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentairesRepository::class)
 */
class Commentaires
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
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     *@ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     */
    private $idUser;

    /**
     *@ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentaires")
     */
    private $idArticle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(?user $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
    public function getIdArticle(): ?article
    {
        return $this->idArticle;
    }

    public function setIdArticle(?article $idArticle): self
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
