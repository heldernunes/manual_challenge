<?php

namespace App\Entity;

use App\Repository\QuestionAnswerRestrictionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionAnswerRestrictionRepository::class)]
class QuestionAnswerRestriction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $answerId = null;

    #[ORM\Column(length: 255)]
    private ?string $exclusionType = null;

    #[ORM\Column(length: 255)]
    private ?string $exclusionDetails = null;

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

    public function getExclusionType(): ?string
    {
        return $this->exclusionType;
    }

    public function setExclusionType(string $exclusionType): static
    {
        $this->exclusionType = $exclusionType;

        return $this;
    }

    public function getExclusionDetails(): ?string
    {
        return $this->exclusionDetails;
    }

    public function setExclusionDetails(string $exclusionDetails): static
    {
        $this->exclusionDetails = $exclusionDetails;

        return $this;
    }
}
