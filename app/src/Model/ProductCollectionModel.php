<?php

namespace App\Model;

use ArrayIterator;

/**
 * @codeCoverageIgnore
 */
class ProductCollectionModel extends ArrayIterator
{
    /**
     * @param array $products
     */
    public function __construct(array $products)
    {
        parent::__construct();

        foreach ($products as $product) {
            $this->append(new ProductModel($product));
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
