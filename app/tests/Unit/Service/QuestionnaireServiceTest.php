<?php

namespace App\Tests\Unit\Service;

use App\Model\Request\QuestionnaireReqModel;
use App\Model\Response\BaseResponseModel;
use App\Model\Response\QuestionnaireResponseModel;
use App\Plugin\QuestionnairePlugin;
use App\Plugin\QuestionnaireQuestionsPlugin;
use App\Service\QuestionnaireService;
use App\Transformer\BaseTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionnaireServiceTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetQuestionnaireById(): void
    {
        $expectedQuestionnaireResponseModel = new QuestionnaireResponseModel([
            'id' => 1,
            'name' => 'Questionnaire 1',
            'description' => 'This is a test questionnaire',
        ]);


        $baseResponseModel = new BaseResponseModel();
        $baseResponseModel->setData($expectedQuestionnaireResponseModel->toArray());
        $baseResponseModel->setSuccess(true);
        $expectedResponse = new JsonResponse($baseResponseModel->toArray(), Response::HTTP_OK);

        $questionnaireReqModel = (new QuestionnaireReqModel());
        $questionnaireReqModel->setId(1);
        $questionnairePlugin = $this->createMock(QuestionnairePlugin::class);
        $questionnairePlugin->expects($this->once())
            ->method('apply')
            ->with(
                $this->callback(
                    function (QuestionnaireResponseModel $responseModel) use ($expectedQuestionnaireResponseModel) {
                        $this->assertEquals($expectedQuestionnaireResponseModel->getId(), $responseModel->getId());
                        $responseModel->setName($expectedQuestionnaireResponseModel->getName());
                        $responseModel->setDescription($expectedQuestionnaireResponseModel->getDescription());

                        return true;
                    }
                )
            );
        $questionnaireQuestionsPlugin = $this->createMock(QuestionnaireQuestionsPlugin::class);


        $transformer = $this->createMock(BaseTransformer::class);
        $transformer->expects($this->once())
            ->method('apply')
            ->with(
                $this->callback(
                    function (QuestionnaireResponseModel $responseModel) use ($expectedQuestionnaireResponseModel) {
                        $this->assertEquals($expectedQuestionnaireResponseModel->getId(), $responseModel->getId());
                        $this->assertEquals($expectedQuestionnaireResponseModel->getName(), $responseModel->getName());
                        $this->assertEquals(
                            $expectedQuestionnaireResponseModel->getDescription(),
                            $responseModel->getDescription()
                        );

                        return true;
                    }
                )
            )
            ->willReturn($expectedResponse);

        $service = new QuestionnaireService($transformer, [$questionnairePlugin, $questionnaireQuestionsPlugin]);

        $response = $service->getQuestionnaireById($questionnaireReqModel);

        $this->assertEquals($expectedResponse->getContent(), $response->getContent());
    }
}
