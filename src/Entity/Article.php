<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Objet", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $objet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Emplacement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emplacement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Peremption", mappedBy="article", cascade={"persist", "remove"})
     */
    private $peremption;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Etat", mappedBy="article", cascade={"persist", "remove"})
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getPeremption(): ?Peremption
    {
        return $this->peremption;
    }

    public function setPeremption(Peremption $peremption): self
    {
        $this->peremption = $peremption;

        // set the owning side of the relation if necessary
        if ($peremption->getArticle() !== $this) {
            $peremption->setArticle($this);
        }

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(Etat $etat): self
    {
        $this->etat = $etat;

        // set the owning side of the relation if necessary
        if ($etat->getArticle() !== $this) {
            $etat->setArticle($this);
        }

        return $this;
    }
}
