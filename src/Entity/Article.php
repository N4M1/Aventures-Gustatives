<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;


    /**
     * @ORM\Column(type="string", length=255)
     */

    private $imageFile;

    /**
     *@ORM\ManyToOne(targetEntity=User::class, inversedBy="article")
     */
    private $idUser;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="idArticle")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(string $imageFile): self
    {
        $this->imageFile = $imageFile;

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

        /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaires(Commentaires $commentaires): self
    {
        if (!$this->commentaires->contains($commentaires)) {
            $this->commentaires[] = $commentaires;
            $commentaires->setIdArticle($this);
        }

        return $this;
    }

    public function removeCommentaires(Commentaires $commentaires): self
    {
        if ($this->commentaires->removeElement($commentaires)) {
            // set the owning side to null (unless already changed)
            if ($commentaires->setIdArticle($this)) {
                $commentaires->setIdArticle(null);
            }
        }

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
