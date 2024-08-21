<?php

namespace App\Controller;

use App\Model\Request\QuestionnaireReqModel;
use App\Service\QuestionnaireService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaire/{id}', name: 'app_questionnaire_show')]
    #[ParamConverter('questionnaireReqModel')]
    public function index(
        QuestionnaireReqModel $questionnaireReqModel,
        QuestionnaireService $questionnaireService
    ): JsonResponse {
        return $questionnaireService->getQuestionnaireById($questionnaireReqModel);
    }
}
