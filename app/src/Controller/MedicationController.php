<?php

namespace App\Controller;

use App\Model\Request\MedicationReqModel;
use App\Service\MedicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MedicationController extends AbstractController
{
    #[Route('/medication', name: 'app_medication', methods: ['POST'])]
    #[ParamConverter('medicationReqModel')]
    public function index(
        MedicationReqModel $medicationReqModel,
        MedicationService $medicationService,
    ): JsonResponse {
        return $medicationService->getMedicationByQuestionnaireResponses($medicationReqModel);
    }
}
