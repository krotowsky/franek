<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $customer = null;

    #[ORM\Column(length: 255)]
    private ?string $summary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: VideoReview::class, mappedBy: 'ReviewOrder')]
    private Collection $videoReviews;

    public function __construct()
    {
        $this->videoReviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, VideoReview>
     */
    public function getVideoReviews(): Collection
    {
        return $this->videoReviews;
    }

    public function addVideoReview(VideoReview $videoReview): static
    {
        if (!$this->videoReviews->contains($videoReview)) {
            $this->videoReviews->add($videoReview);
            $videoReview->setReviewOrder($this);
        }

        return $this;
    }

    public function removeVideoReview(VideoReview $videoReview): static
    {
        if ($this->videoReviews->removeElement($videoReview)) {
            // set the owning side to null (unless already changed)
            if ($videoReview->getReviewOrder() === $this) {
                $videoReview->setReviewOrder(null);
            }
        }

        return $this;
    }
}
