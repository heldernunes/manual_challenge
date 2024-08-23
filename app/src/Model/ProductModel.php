<?php

namespace App\Model;

/**
 * @codeCoverageIgnore
 */
class ProductModel
{
    use ArrayConversion;

    private int $id;

    private string $category;

    private string $name;

    private float $price;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->setId($values['id'])
            ->setCategory($values['category'])
            ->setName($values['name'] . ' ' . $values['dosage'])
            ->setPrice($values['price']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): ProductModel
    {
        $this->id = $id;
        return $this;
    }

    public function setCategory(string $category): ProductModel
    {
        $this->category = $category;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductModel
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice(float $price): ProductModel
    {
        $this->price = $price;
        return $this;
    }
}
