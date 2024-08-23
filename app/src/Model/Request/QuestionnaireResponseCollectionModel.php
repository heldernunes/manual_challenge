<?php

namespace App\Model\Request;

use ArrayIterator;

/**
 * @codeCoverageIgnore
 */
class QuestionnaireResponseCollectionModel extends ArrayIterator
{
    /**
     * @param array $responses
     */
    public function __construct(array $responses)
    {
        parent::__construct();

        foreach ($responses as $response) {
            $this->append(new QuestionnaireResponseModel($response));
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
