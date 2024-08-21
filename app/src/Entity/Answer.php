<?php

namespace App\Entity;

use App\Model\ArrayConversion;
use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    use ArrayConversion;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $questionId = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?int $followUpQuestionId = null;

    #[ORM\Column(nullable: true)]
    private ?int $questionAnswerRestrictionId = null;

    #[ORM\Column(nullable: true)]
    private ?int $productDosageId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionId(): ?int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): static
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getFollowUpQuestionId(): ?int
    {
        return $this->followUpQuestionId;
    }

    public function setFollowUpQuestionId(?int $followUpQuestionId): static
    {
        $this->followUpQuestionId = $followUpQuestionId;

        return $this;
    }

    public function getQuestionAnswerRestrictionId(): ?int
    {
        return $this->questionAnswerRestrictionId;
    }

    public function setQuestionAnswerRestrictionId(?int $questionAnswerRestrictionId): static
    {
        $this->questionAnswerRestrictionId = $questionAnswerRestrictionId;

        return $this;
    }

    public function getProductDosageId(): ?int
    {
        return $this->productDosageId;
    }

    public function setProductDosageId(?int $productDosageId): static
    {
        $this->productDosageId = $productDosageId;

        return $this;
    }
}
