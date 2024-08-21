<?php

namespace App\Plugin;

use App\Model\AnswerCollectionModel;
use App\Model\AnswerModel;
use App\Model\QuestionCollectionModel;
use App\Model\Response\QuestionnaireResponseModel;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;

class QuestionnaireAnswersPlugin implements QuestionnairePluginInterface
{
    public function __construct(
        private readonly AnswerRepository $answerRepository,
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
        $criteria = array_map(
            fn(array $question) => $question['id'],
            $questionnaireResponseModel->getQuestions()->toArray()
        );

        $answers = $this->answerRepository->findQuestionnaireAnswersByQuestionIds($criteria);

        $this->mapQuestionnaireQuestions($answers, $questionnaireResponseModel);
    }

    /**
     * @param array<\App\Entity\Answer> $answers
     * @param \App\Model\Response\QuestionnaireResponseModel $questionnaireResponseModel
     */
    private function mapQuestionnaireQuestions(
        array $answers,
        QuestionnaireResponseModel &$questionnaireResponseModel
    ): void {
        $mappedAnswers = array_reduce($answers, function ($carry, $answer) {
            $carry[$answer['questionId']][] = new AnswerModel($answer);
            return $carry;
        }, []);

        /** @var \App\Model\QuestionModel $question */
        foreach ($questionnaireResponseModel->getQuestions() as $question) {
            $answerCollectionModel = new AnswerCollectionModel($mappedAnswers[$question->getId()] ?? []);
            $question->setAnswers($answerCollectionModel);
        }
    }
}
