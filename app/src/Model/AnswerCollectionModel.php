<?php

namespace App\Model;

use ArrayIterator;

class AnswerCollectionModel extends ArrayIterator
{
    public function __construct(array $answers)
    {
        parent::__construct();

        foreach ($answers as $answer) {
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
