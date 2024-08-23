<?php

namespace App\Model;

/**
 * @codeCoverageIgnore
 */
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


    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->answer = $values['text'] ?? null;
        $this->questionId = $values['questionId'] ?? null;
        $this->followUpQuestionId = $values['followUpQuestionId'] ?? null;
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

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function getQuestionId(): ?int
    {
        return $this->questionId;
    }

    public function getFollowUpQuestionId(): ?int
    {
        return $this->followUpQuestionId;
    }
}
