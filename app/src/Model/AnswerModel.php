<?php

namespace App\Model;

class AnswerModel
{
    use ArrayConversion;

    /**
     * @var int|mixed|null
     */
    private ?int $id;

    /**
     * @var string|mixed|null
     */
    private ?string $answer;

    /**
     * @var int|mixed|null
     */
    private ?int $questionId;

    /**
     * @var int|null
     */
    private ?int $followUpQuestionId;

//    /**
//     * @var string|null
//     */
//    private ?string $questionAnswerRestrictionId;
//
//    /**
//     * @var string|null
//     */
//    private ?string $productDosageId;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->answer = $values['text'] ?? null;
        $this->questionId = $values['questionId'] ?? null;
        $this->followUpQuestionId = $values['followUpQuestionId'] ?? null;
//        $this->questionAnswerRestrictionId = $values['questionAnswerRestrictionId'] ?? null;
//        $this->productDosageId = $values['productDosageId'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
