<?php

namespace App\Service;

use App\Model\Request\QuestionnaireReqModel;
use App\Model\Response\QuestionnaireResponseModel;
use App\Transformer\BaseTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnaireService
{
    private array $pluginOrder = [
        'App\Plugin\QuestionnairePlugin',
        'App\Plugin\QuestionnaireQuestionsPlugin',
        'App\Plugin\QuestionnaireAnswersPlugin',
    ];
    private array $pluginStack;

    /**
     * @param \App\Transformer\BaseTransformer $transformer
     * @param iterable<\App\Plugin\QuestionnairePluginInterface> $pluginStack
     */
    public function __construct(
        private readonly BaseTransformer $transformer,
        iterable $pluginStack,
    ) {
        $this->pluginStack = $this->sortPlugins($pluginStack);
    }

    /**
     * Sort plugins based on the defined order.
     *
     * @param iterable $pluginStack
     * @return array
     */
    private function sortPlugins(iterable $pluginStack): array
    {
        $plugins = iterator_to_array($pluginStack);
        usort($plugins, function ($a, $b) {
            $aIndex = array_search(get_class($a), $this->pluginOrder);
            $bIndex = array_search(get_class($b), $this->pluginOrder);
            return $aIndex <=> $bIndex;
        });
        return $plugins;
    }

    /**
     * @param \App\Model\Request\QuestionnaireReqModel $questionnaireReqModel
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getQuestionnaireById(QuestionnaireReqModel $questionnaireReqModel): JsonResponse
    {
        $questionnaireResponseModel = new QuestionnaireResponseModel($questionnaireReqModel->toArray());

        foreach ($this->pluginStack as $plugin) {
            $plugin->apply($questionnaireResponseModel);
        }
        return $this->transformer->apply($questionnaireResponseModel, true);
    }
}
