<?php

namespace App\Tests\Unit\Plugin;

use App\Entity\Question;
use App\Model\Response\QuestionnaireResponseModel;
use App\Plugin\QuestionnaireQuestionsPlugin;
use App\Repository\QuestionRepository;
use PHPUnit\Framework\TestCase;

class QuestionnaireQuestionsPluginTest extends TestCase
{
    public function testGetQuestionnaireQuestions()
    {
        $id = 1;
        $text = 'Questionnaire 1 question?';

        $questionEntity = (new Question());
        $questionEntity->setId($id)
            ->setParentQuestionId(null)
            ->setQuestionnaireId(1)
            ->setText($text)
            ->setOrderNumber(1)
            ->setQuestionNumber(1);

        $questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $questionRepositoryMock->expects($this->once())
            ->method('findQuestionnaireQuestionsByQuestionnaireId')
            ->willReturn([$questionEntity]);

        $questionnaireResponseModel = new QuestionnaireResponseModel(['id' => $id]);

        $plugin = new QuestionnaireQuestionsPlugin($questionRepositoryMock);
        $plugin->apply($questionnaireResponseModel);

        $this->assertEquals($id, $questionnaireResponseModel->getId());
        /** @var \App\Model\QuestionModel $questionModel */
        $questionModel = $questionnaireResponseModel->getQuestions()[0];
        $this->assertEquals('1 ' . $text, $questionModel->getQuestion());
        $this->assertEquals(1, $questionModel->getOrderNumber());
        $this->assertNull($questionModel->getParentQuestionId());
    }
}
