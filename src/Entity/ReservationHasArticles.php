<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationHasArticlesRepository")
 */
class ReservationHasArticles
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="reservationHasArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;


    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(int $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(int $article): self
    {
        $this->article = $article;

        return $this;
    }
}
