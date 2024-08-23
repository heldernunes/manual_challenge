<?php

namespace App\Model\Request;

use App\Model\Request\RequestModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @codeCoverageIgnore
 */
class QuestionnaireReqModel extends BaseReqModel
{
    /**
     * @Assert\Type("int", message="It must be an int.")
     *
     * @var int
     */
    protected int $id;

    /**
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
