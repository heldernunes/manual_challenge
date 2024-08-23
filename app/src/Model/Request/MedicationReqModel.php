<?php

namespace App\Model\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @codeCoverageIgnore
 */
class MedicationReqModel implements RequestModelInterface
{
    /**
     * @Assert\Type("int", message="It must be an int.")
     *
     * @var int
     */
    protected int $questionnaireId;


    /**
     * @Assert\Type("App\Model\Request\QuestionnaireResponseCollectionModel")
     *
     * @var QuestionnaireResponseCollectionModel
     */
    protected QuestionnaireResponseCollectionModel $responses;

    public function __construct(int $questionnaireId, array $questionnaireResponseCollectionModel)
    {
        $this->setQuestionnaireId($questionnaireId);
        $this->setResponses($questionnaireResponseCollectionModel);
    }

    /**
     * @return int
     */
    public function getQuestionnaireId(): int
    {
        return $this->questionnaireId;
    }

    /**
     * @param int $questionnaireId
     *
     * @return \App\Model\Request\MedicationReqModel
     */
    public function setQuestionnaireId(int $questionnaireId): MedicationReqModel
    {
        $this->questionnaireId = $questionnaireId;

        return $this;
    }

    /**
     * @return \App\Model\Request\QuestionnaireResponseCollectionModel
     */
    public function getResponses(): QuestionnaireResponseCollectionModel
    {
        return $this->responses;
    }

    /**
     * @param array $responses
     *
     * @return $this
     */
    public function setResponses(array $responses): MedicationReqModel
    {
        $this->responses = new QuestionnaireResponseCollectionModel($responses);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'questionnaireId' => $this->questionnaireId,
            'responses' => $this->responses->toArray()
        ];
    }
}
