<?php

namespace App\Model;

use ArrayIterator;

/**
 * @codeCoverageIgnore
 */
class AnswerCollectionModel extends ArrayIterator
{
    public function __construct(array $questions)
    {
        parent::__construct();

        foreach ($questions as $answer) {
            $this->append($answer);
        }
    }

    public function toArray(): array
    {
        return array_map(
            function ($answerModel) {
                /** @var $answerModel \App\Model\AnswerModel */
                return $answerModel->toArray();
            },
            array_values(iterator_to_array($this))
        );
    }
}
