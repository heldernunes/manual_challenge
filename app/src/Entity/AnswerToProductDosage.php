<?php

namespace App\Entity;

use App\Repository\AnswerToProductDosageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @codeCoverageIgnore
 */
#[ORM\Entity(repositoryClass: AnswerToProductDosageRepository::class)]
class AnswerToProductDosage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $answerId = null;

    #[ORM\Column]
    private ?int $productDosageId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswerId(): ?int
    {
        return $this->answerId;
    }

    public function setAnswerId(int $answerId): static
    {
        $this->answerId = $answerId;

        return $this;
    }

    public function getProductDosageId(): ?int
    {
        return $this->productDosageId;
    }

    public function setProductDosageId(int $productDosageId): static
    {
        $this->productDosageId = $productDosageId;

        return $this;
    }
}
