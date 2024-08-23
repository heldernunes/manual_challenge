<?php

namespace App\Model;

/**
 * @codeCoverageIgnore
 */
class QuestionnaireModel
{
    use ArrayConversion;

    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->description = $values['description'] ?? null;
    }
}
