<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeremptionRepository")
 */
class Peremption
{
    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\Article", inversedBy="peremption", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="date")
     */
    private $datePeremption;

    public function getDatePeremption(): ?\DateTimeInterface
    {
        return $this->datePeremption;
    }

    public function setDatePeremption(\DateTimeInterface $datePeremption): self
    {
        $this->datePeremption = $datePeremption;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
