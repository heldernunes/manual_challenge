<?php

namespace App\Middleware;

use App\Model\Request\QuestionnaireReqModel;
use Symfony\Component\HttpFoundation\Request;

class GetQuestionnaireParamConverter extends Middleware
{
    public const PARAM_CONVERTER_NAME = 'questionnaireReqModel';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function createRequestObject(Request $request): void
    {
        $requestObj = new QuestionnaireReqModel($request->attributes->all());

        $this->addRequestToValidate($requestObj);
    }
}
