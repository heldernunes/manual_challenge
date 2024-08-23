<?php

namespace App\Model\Response;

use App\Model\ArrayConversion;
use App\Model\ProductCollectionModel;
use App\Model\ProductModel;
use App\Model\QuestionModel;
use ArrayIterator;

class MedicationResponseModel extends ArrayIterator implements ResponseModelInterface
{
    /**
     * @var \ArrayIterator<\App\Model\QuestionModel>|null
     */
    protected ?ArrayIterator $products;

    /**
     * @param array $products
     */
    public function __construct(array $products)
    {
        parent::__construct($products);

        $this->setProducts(new ProductCollectionModel($products));
    }

    public function setProducts(ProductCollectionModel $products): void
    {
        $this->products = $products;
    }
    public function toArray(): array
    {
        return [
            'products' => !empty($this->products) ? array_map(
                fn(ProductModel $product) => $product->toArray(),
                iterator_to_array($this->products)
            ) : null,
        ];
    }
}
