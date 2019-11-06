<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReservationHasArticles", mappedBy="reservation")
     */
    private $reservationHasArticles;

    public function __construct()
    {
        $this->reservationHasArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection|ReservationHasArticles[]
     */
    public function getReservationHasArticles(): Collection
    {
        return $this->reservationHasArticles;
    }

    public function addReservationHasArticle(ReservationHasArticles $reservationHasArticle): self
    {
        if (!$this->reservationHasArticles->contains($reservationHasArticle)) {
            $this->reservationHasArticles[] = $reservationHasArticle;
            $reservationHasArticle->setReservation($this);
        }

        return $this;
    }

    public function removeReservationHasArticle(ReservationHasArticles $reservationHasArticle): self
    {
        if ($this->reservationHasArticles->contains($reservationHasArticle)) {
            $this->reservationHasArticles->removeElement($reservationHasArticle);
            // set the owning side to null (unless already changed)
            if ($reservationHasArticle->getReservation() === $this) {
                $reservationHasArticle->setReservation(null);
            }
        }

        return $this;
    }
}
