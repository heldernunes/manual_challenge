<?php

namespace App\Model;

use ArrayIterator;

class QuestionModel
{
    use ArrayConversion;

    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string|null
     */
    private ?string $question = null;

    /**
     * @var int|null
     */
    private ?int $orderNumber = null;

    /**
     * @var int|null
     */
    private ?int $parentQuestionId = null;

    /**
     * @var \ArrayIterator<\App\Model\AnswerModel>|null
     */
    protected ?ArrayIterator $answers;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->question = $this->buildQuestionString($values);
        $this->orderNumber = $values['orderNumber'] ?? null;
        $this->parentQuestionId = $values['parentQuestionId'] ?? null;
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
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param string|null $question
     */
    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return int|null
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    /**
     * @param int|null $orderNumber
     */
    public function setOrderNumber(?int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return int|null
     */
    public function getParentQuestionId(): ?int
    {
        return $this->parentQuestionId;
    }

    /**
     * @param int|null $parentQuestionId
     */
    public function setParentQuestionId(?int $parentQuestionId): void
    {
        $this->parentQuestionId = $parentQuestionId;
    }

    /**
     * @return string|null
     */
    public function getAnswers(): ?string
    {
        return $this->answers;
    }

    /**
     * @param \App\Model\AnswerCollectionModel|null $answers
     *
     * @return void
     */
    public function setAnswers(?AnswerCollectionModel $answers): void
    {
        $this->answers = $answers;
    }

    /**
     * @param array $values
     *
     * @return string|null
     */
    private function buildQuestionString(array $values): ?string
    {
        return (($values['questionNumber'] ?? '') . ' ' . ($values['text'] ?? '')) ?? null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'orderNumber' => $this->orderNumber,
            'parentQuestionId' => $this->parentQuestionId,
            'answers' => !empty($this->answers) ? array_map(
                fn(AnswerModel $answer) => $answer->toArray(),
                iterator_to_array($this->answers)
            ) : null,
        ];
    }
}
