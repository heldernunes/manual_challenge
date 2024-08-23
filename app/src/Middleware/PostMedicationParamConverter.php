<?php

namespace App\Middleware;

use App\Model\Request\MedicationReqModel;
use App\Model\Request\QuestionnaireResponseCollectionModel;
use Symfony\Component\HttpFoundation\Request;

class PostMedicationParamConverter extends Middleware
{
    public const PARAM_CONVERTER_NAME = 'medicationReqModel';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function createRequestObject(Request $request): void
    {
        $content = json_decode($request->getContent(), true);

        $requestObj = new MedicationReqModel(
            $content['questionnaireId'],
            $content['responses']
        );

        $this->addRequestToValidate($requestObj);
    }
}
