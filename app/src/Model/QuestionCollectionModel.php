<?php

namespace App\Model;

use ArrayIterator;

class QuestionCollectionModel extends ArrayIterator
{
    /**
     * @param array $answers
     */
    public function __construct(array $answers)
    {
        parent::__construct();

        foreach ($answers as $question) {
            $this->append(new QuestionModel($question->toArray()));
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(
            function ($questionModel) {
                /** @var $questionModel \App\Model\QuestionModel */
                return $questionModel->toArray();
            },
            array_values(iterator_to_array($this))
        );
    }
}
