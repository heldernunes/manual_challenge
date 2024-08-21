<?php

namespace App\Plugin;

use App\Model\QuestionCollectionModel;
use App\Model\Response\QuestionnaireResponseModel;
use App\Repository\QuestionRepository;

class QuestionnaireQuestionsPlugin implements QuestionnairePluginInterface
{
    public function __construct(
        private readonly QuestionRepository $questionRepository,
    ) {
    }

    /**
     * @param \App\Model\Response\QuestionnaireResponseModel $questionnaireResponseModel
     *
     * @return void
     *
     * @throws \Exception
     */
    public function apply(QuestionnaireResponseModel &$questionnaireResponseModel): void
    {
        $criteria = [
            'questionnaire_id' => $questionnaireResponseModel->getId(),
        ];

        $questions = $this->questionRepository->findQuestionnaireQuestionsByQuestionnaireId($criteria);

        $this->mapQuestionnaireQuestions($questions, $questionnaireResponseModel);
    }

    /**
     * @param array<\App\Entity\Question> $questions
     * @param \App\Model\Response\QuestionnaireResponseModel $questionnaireResponseModel
     */
    private function mapQuestionnaireQuestions(
        array $questions,
        QuestionnaireResponseModel &$questionnaireResponseModel
    ): void {
        $questionnaireResponseModel->setProperties([
            'questions' => new QuestionCollectionModel($questions),
        ]);
    }
}
