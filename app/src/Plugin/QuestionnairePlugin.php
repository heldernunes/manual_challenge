<?php

namespace App\Plugin;

use App\Entity\Questionnaire;
use App\Model\Response\QuestionnaireResponseModel;
use App\Repository\QuestionnaireRepository;
use Exception;

class QuestionnairePlugin implements QuestionnairePluginInterface
{
    /**
     * @param \App\Repository\QuestionnaireRepository $questionnaireRepository
     */
    public function __construct(
        private readonly QuestionnaireRepository $questionnaireRepository,
    ) {
    }

    /**
     * @param \App\Model\Response\QuestionnaireResponseModel $questionnaireResponseModel
     *
     * @return void
     * @throws \Exception
     */
    public function apply(QuestionnaireResponseModel &$questionnaireResponseModel): void
    {
        $criteria = array_filter($questionnaireResponseModel->toArray(), fn($value) => !is_null($value));

        $questionnaire = $this->questionnaireRepository->findQuestionnaireById($criteria);

        $this->mapQuestionnaire($questionnaire, $questionnaireResponseModel);
    }

    /**
     * @param \App\Entity\Questionnaire|null $questionnaire
     * @param \App\Model\Response\QuestionnaireResponseModel $questionnaireResponseModel
     *
     * @throws \Exception
     */
    private function mapQuestionnaire(
        ?Questionnaire $questionnaire,
        QuestionnaireResponseModel &$questionnaireResponseModel
    ): void {
        if ($questionnaire === null) {
            throw new Exception('Questionnaire not found');
        }

        $questionnaireResponseModel->setProperties($questionnaire->toArray());
    }
}
