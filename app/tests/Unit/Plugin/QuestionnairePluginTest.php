<?php

namespace App\Tests\Unit\Plugin;

use App\Entity\Questionnaire;
use App\Model\Response\QuestionnaireResponseModel;
use App\Plugin\QuestionnairePlugin;
use App\Repository\QuestionnaireRepository;
use Exception;
use PHPUnit\Framework\TestCase;

class QuestionnairePluginTest extends TestCase
{
    public function testGetQuestionnaire()
    {
        $id = 1;
        $name = 'Questionnaire 1';
        $description = 'This is a test questionnaire';

        $questionnaireEntity = (new Questionnaire());
        $questionnaireEntity->setId($id)
            ->setName($name)
            ->setDescription($description);

        $questionnaireRepositoryMock = $this->createMock(QuestionnaireRepository::class);
        $questionnaireRepositoryMock->expects($this->once())
            ->method('findQuestionnaireById')
            ->willReturn($questionnaireEntity);

        $questionnaireResponseModel = new QuestionnaireResponseModel(['id' => $id]);

        $this->assertNull($questionnaireResponseModel->getName());
        $this->assertNull($questionnaireResponseModel->getDescription());

        $plugin = new QuestionnairePlugin($questionnaireRepositoryMock);
        $plugin->apply($questionnaireResponseModel);

        $this->assertEquals($id, $questionnaireResponseModel->getId());
        $this->assertEquals($name, $questionnaireResponseModel->getName());
        $this->assertEquals($description, $questionnaireResponseModel->getDescription());
    }

    public function testGetQuestionnaireFails()
    {
        $id = 1;
        $name = 'Questionnaire 1';
        $description = 'This is a test questionnaire';

        $questionnaireRepositoryMock = $this->createMock(QuestionnaireRepository::class);
        $questionnaireRepositoryMock->expects($this->once())
            ->method('findQuestionnaireById')
            ->willReturn(null);

        $questionnaireResponseModel = new QuestionnaireResponseModel(['id' => $id]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Questionnaire not found');

        $plugin = new QuestionnairePlugin($questionnaireRepositoryMock);
        $plugin->apply($questionnaireResponseModel);
    }
}
