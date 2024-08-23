<?php

namespace App\Model\Response;

use App\Model\ArrayConversion;
use App\Model\QuestionModel;
use ArrayIterator;

class QuestionnaireResponseModel extends ArrayIterator implements ResponseModelInterface
{
    /**
     * @var int|null
     */
    protected ?int $id;

    /**
     * @var string|null
     */
    protected ?string $name;

    /**
     * @var string|null
     */
    protected ?string $description;

    /**
     * @var \ArrayIterator<\App\Model\QuestionModel>|null
     */
    protected ?ArrayIterator $questions;

    /**
     * @param array $questionnaire
     */
    public function __construct(array $questionnaire)
    {
        parent::__construct($questionnaire);

        $this->id = $questionnaire['id'] ?? null;
        $this->name = $questionnaire['name'] ?? null;
        $this->description = $questionnaire['description'] ?? null;
    }

    public function setProperties(array $properties): void
    {
        foreach ($properties as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return \ArrayIterator|null
     */
    public function getQuestions(): ?ArrayIterator
    {
        return $this->questions;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setQuestions(?ArrayIterator $questions): void
    {
        $this->questions = $questions;
    }



    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'questions' => !empty($this->questions) ? array_map(
                fn(QuestionModel $question) => $question->toArray(),
                iterator_to_array($this->questions)
            ) : null,
        ];
    }
}
