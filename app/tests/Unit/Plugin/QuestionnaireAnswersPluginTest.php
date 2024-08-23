<?php

namespace App\Tests\Unit\Plugin;

use App\Entity\Answer;
use App\Model\QuestionCollectionModel;
use App\Model\QuestionModel;
use App\Model\Response\QuestionnaireResponseModel;
use App\Plugin\QuestionnaireAnswersPlugin;
use App\Repository\AnswerRepository;
use PHPUnit\Framework\TestCase;

class QuestionnaireAnswersPluginTest extends TestCase
{
    public function testGetQuestionnaireQuestions()
    {
        $id = 1;
        $text = 'Questionnaire 1 question?';

        $questionEntity = (new Answer());
        $questionEntity->setId($id)
            ->setQuestionId($id)
            ->setText($text)
            ->setFollowUpQuestionId(null)
            ->setQuestionAnswerRestrictionId(null);

        $questionModel = new QuestionModel($questionEntity->toArray());
        $questionCollectionModel = new QuestionCollectionModel([$questionModel]);

        $answerRepositoryMock = $this->createMock(AnswerRepository::class);
        $answerRepositoryMock->expects($this->once())
            ->method('findQuestionnaireAnswersByQuestionIds')
            ->willReturn([$questionEntity->toArray()]);

        $questionnaireResponseModel = new QuestionnaireResponseModel(['id' => $id]);
        $questionnaireResponseModel->setQuestions($questionCollectionModel);

        $plugin = new QuestionnaireAnswersPlugin($answerRepositoryMock);
        $plugin->apply($questionnaireResponseModel);

        $this->assertEquals($id, $questionnaireResponseModel->getId());
        /** @var \App\Model\QuestionModel $questionModel */
        $questionModel = $questionnaireResponseModel->getQuestions()[0];
        /** @var \App\Model\AnswerModel $answerModel */
        $answerModel = $questionModel->getAnswers()[0];
        $this->assertEquals($text, $answerModel->getAnswer());
        $this->assertEquals($id, $answerModel->getQuestionId());
        $this->assertNull($answerModel->getFollowUpQuestionId());
    }
}
