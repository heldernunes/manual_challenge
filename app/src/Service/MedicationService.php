<?php

namespace App\Service;

use App\Entity\Answer;
use App\Model\Request\MedicationReqModel;
use App\Model\Request\QuestionnaireResponseCollectionModel;
use App\Model\Response\ErrorResponseModel;
use App\Model\Response\MedicationResponseModel;
use App\Model\Response\QuestionnaireResponseModel;
use App\Repository\AnswerRepository;
use App\Repository\AnswerToProductDosageRepository;
use App\Repository\ProductDosageRepository;
use App\Repository\ProductRepository;
use App\Repository\QuestionAnswerRestrictionRepository;
use App\Service\Product\ProductExclusionVoter;
use App\Transformer\BaseTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MedicationService
{
    /**
     * @param \App\Transformer\BaseTransformer $transformer
     * @param \App\Repository\QuestionAnswerRestrictionRepository $questionAnswerRestrictionRepository
     * @param \App\Service\Product\ProductExclusionVoter $productRestrictionVoter
     * @param \App\Repository\AnswerRepository $answerRepository
     * @param \App\Repository\ProductRepository $productRepository
     * @param \App\Repository\AnswerToProductDosageRepository $answerToProductDosageRepository
     */
    public function __construct(
        private readonly BaseTransformer $transformer,
        private readonly QuestionAnswerRestrictionRepository $questionAnswerRestrictionRepository,
        private readonly ProductExclusionVoter $productRestrictionVoter,
        private readonly AnswerRepository $answerRepository,
        private readonly ProductRepository $productRepository,
        private readonly AnswerToProductDosageRepository $answerToProductDosageRepository,
    ) {
    }

    /**
     * @param \App\Model\Request\MedicationReqModel $medicationReqModel
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getMedicationByQuestionnaireResponses(MedicationReqModel $medicationReqModel): JsonResponse
    {
        $exclusions = $this->questionAnswerRestrictionRepository->findRestrictionsByType(
            ['exclusionType' => QuestionAnswerRestrictionRepository::RESTRICTION_TYPE_EXCLUDE_ALL]
        );

        $mappedExclusions = [];
        foreach ($exclusions as $exclusion) {
            $mappedExclusions[$exclusion->getAnswerId()] = $exclusion;
        }

        $this->productRestrictionVoter->setExclusions($mappedExclusions);
        $responses = $medicationReqModel->getResponses();
        if (!$this->productRestrictionVoter->vote($responses)) {
            $errorResponseModel = new ErrorResponseModel();
            $errorResponseModel->setDescription($this->productRestrictionVoter->getExclusionDetails());
            $errorResponseModel->setCode(Response::HTTP_NOT_FOUND);
            return $this->transformer->apply($errorResponseModel, true);
        }

        $partialExcludedAnswerID = $this->checkForPartialExclusions($responses);
        if (is_numeric($partialExcludedAnswerID)) {
            $answers = $this->answerRepository->findAnswerAndRestriction(['id' => $partialExcludedAnswerID]);
            $dosageIds = array_filter(
                array_map(function (array $answer) {
                    return $answer['productDosageId'];
                }, $answers)
            );

            $products = $this->productRepository->findProductsByProductDosageIds($dosageIds);

            return $this->sendMedicalProductsResponse($products);
        }

        $answerIds = array_map(function ($response) {
            return $response['answerId'];
        }, $responses->toArray());

        $dosageIds = array_column(
            $this->answerToProductDosageRepository->findDosageIdsByAnswerIds($answerIds),
            'productDosageId'
        );

        if (!empty($dosageIds)) {
            $products = $this->productRepository->findProductsByProductDosageIds($dosageIds);

            return $this->sendMedicalProductsResponse($products);
        }

        $products = $this->productRepository->findAllProductsWithDosage();

        return $this->sendMedicalProductsResponse($products);
    }

    /**
     * @param \App\Model\Request\QuestionnaireResponseCollectionModel $responses
     *
     * @return bool|int
     */
    private function checkForPartialExclusions(QuestionnaireResponseCollectionModel $responses): bool|int
    {
        $softExclusions = $this->questionAnswerRestrictionRepository->findRestrictionsNotByType(
            ['exclusionType' => QuestionAnswerRestrictionRepository::RESTRICTION_TYPE_EXCLUDE_ALL]
        );

        foreach ($responses as $response) {
            $answerId = $response->getAnswerId();
            if ($this->hasExcludeAllRestriction($answerId, $softExclusions)) {
                return $answerId;
            }
        }

        return false;
    }

    /**
     * @param int $answerId
     * @param array $softExclusions
     *
     * @return bool
     */
    private function hasExcludeAllRestriction(int $answerId, array $softExclusions): bool
    {
        foreach ($softExclusions as $restriction) {
            if ($restriction->getAnswerId() === $answerId) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $answers
     *
     * @return array
     */
    private function getDosageIds(array $answers): array
    {
        return array_filter(array_map(function (Answer $answer) {
            return $answer->getAnswerToProductDosageId();
        }, $answers));
    }

    /**
     * @param array $products
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function sendMedicalProductsResponse(array $products): JsonResponse
    {
        $medicationResponseModel = new MedicationResponseModel($products);

        return $this->transformer->apply($medicationResponseModel, true);
    }
}
