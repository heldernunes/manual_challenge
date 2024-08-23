<?php

namespace App\Model;

use ArrayIterator;

/**
 * @codeCoverageIgnore
 */
class QuestionCollectionModel extends ArrayIterator
{
    /**
     * @param array $questions
     */
    public function __construct(array $questions)
    {
        parent::__construct();

        foreach ($questions as $question) {
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
