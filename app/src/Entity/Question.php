<?php

namespace App\Entity;

use App\Model\ArrayConversion;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @codeCoverageIgnore
 */
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    use ArrayConversion;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $questionnaireId = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?int $parentQuestionId = null;

    #[ORM\Column]
    private ?int $orderNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $questionNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getQuestionnaireId(): ?int
    {
        return $this->questionnaireId;
    }

    public function setQuestionnaireId(int $questionnaireId): static
    {
        $this->questionnaireId = $questionnaireId;

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

    public function getParentQuestionId(): ?int
    {
        return $this->parentQuestionId;
    }

    public function setParentQuestionId(?int $parentQuestionId): static
    {
        $this->parentQuestionId = $parentQuestionId;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getQuestionNumber(): ?string
    {
        return $this->questionNumber;
    }

    public function setQuestionNumber(?string $questionNumber): static
    {
        $this->questionNumber = $questionNumber;

        return $this;
    }
}
