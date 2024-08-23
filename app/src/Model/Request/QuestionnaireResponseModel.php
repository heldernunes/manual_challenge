<?php

namespace App\Model\Request;

use App\Model\ArrayConversion;

/**
 * @codeCoverageIgnore
 */
class QuestionnaireResponseModel
{
    use ArrayConversion;

    private int $questionId;

    private int $answerId;

    public function __construct(array $values)
    {
        $this->setQuestionId($values['questionId']);
        $this->setAnswerId($values['answerId']);
    }

    public function setQuestionId(int $questionId): static
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function setAnswerId(int $answerId): static
    {
        $this->answerId = $answerId;

        return $this;
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function getAnswerId(): int
    {
        return $this->answerId;
    }
}
