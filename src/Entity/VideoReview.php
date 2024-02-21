<?php

namespace App\Entity;

use App\Repository\VideoReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoReviewRepository::class)]
class VideoReview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $videoUrl = null;

    #[ORM\ManyToOne(inversedBy: 'videoReviews')]
    private ?Order $ReviewOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getReviewOrder(): ?Order
    {
        return $this->ReviewOrder;
    }

    public function setReviewOrder(?Order $ReviewOrder): static
    {
        $this->ReviewOrder = $ReviewOrder;

        return $this;
    }
}
