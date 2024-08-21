<?php

namespace App\Middleware;

use App\Model\Request\RequestCollectionModel;
use App\Model\Request\RequestModelInterface;
use App\Service\ValidatorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class Middleware implements ParamConverterInterface
{
    private ValidatorService $validatorService;

    protected RequestCollectionModel $requestCollection;

    protected const PARAM_CONVERTER_NAME = "";


    /**
     * @param \App\Service\ValidatorService $validatorService
     */
    public function __construct(ValidatorService $validatorService)
    {
        $this->validatorService = $validatorService;
        $this->requestCollection = new RequestCollectionModel();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $this->createRequestObject($request);

        // Now, let's validate the request
        $this->validateRequestModels($this->requestCollection);

        // no errors then add request model to request
        $request->attributes->set($configuration->getName(), $this->requestCollection[0]);

        return true;
    }

    /**
     * @param \App\Model\Request\RequestModelInterface $reqModel
     *
     * @return void
     */
    public function addRequestToValidate(RequestModelInterface $reqModel): void
    {
        $this->requestCollection[] = $reqModel;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    abstract protected function createRequestObject(Request $request): void;

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        if ($configuration->getName() == static::PARAM_CONVERTER_NAME) {
            return true;
        }

        return false;
    }

    /**
     * @param \App\Model\Request\RequestModelInterface $requestModel
     *
     * @return void
     */
    protected function validateRequestModel(RequestModelInterface $requestModel): void
    {
        $this->validatorService->validateRequestModel($requestModel);
    }

    /**
     * @param \App\Model\Request\RequestCollectionModel $requestModels
     *
     * @return void
     */
    protected function validateRequestModels(RequestCollectionModel $requestModels): void
    {
        $this->validatorService->validateRequestModels($requestModels);
    }
}
