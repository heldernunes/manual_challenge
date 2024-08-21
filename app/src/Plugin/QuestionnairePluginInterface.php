<?php

namespace App\Plugin;

use App\Model\Response\QuestionnaireResponseModel;

interface QuestionnairePluginInterface
{
    /**
     * @param \App\Model\Response\QuestionnaireResponseModel $questionnaireResponseModel
     */
    public function apply(QuestionnaireResponseModel &$questionnaireResponseModel): void;
}
