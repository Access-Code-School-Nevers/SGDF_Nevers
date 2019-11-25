<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjetRepository")
 */
class Objet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private $pcb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="objet")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="smallint", columnDefinition="TinyInt(1) NOT NULL")
     */
    private $perissable;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getPcb(): ?int
    {
        return $this->pcb;
    }

    public function setPcb(int $pcb): self
    {
        $this->pcb = $pcb;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setObjet($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getObjet() === $this) {
                $article->setObjet(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPerissable(): ?int
    {
        return $this->perissable;
    }

    public function setPerissable(int $perissable): self
    {
        $this->perissable = $perissable;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('titre', new Assert\Regex([
            'pattern' => '/\d/',
            'match' => false,
            'message' => 'Ceci est un champ texte !',
        ]));
        $metadata->addPropertyConstraint('pcb', new Assert\Regex([
            'pattern' => '[0-9]',
            'match' => false,
            'message' => 'ne prend en compte que des nombres entiers !',
        ]));
    }
}
