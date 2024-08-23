<?php

namespace App\Transformer;

use App\Model\Response\BaseResponseModel;
use App\Model\Response\ErrorResponseModel;
use App\Model\Response\ResponseModelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseTransformer implements TransformerInterface
{
    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     * @Assert\Type("string")
     *
     * @var string
     */
    private $contentType = 'application/json';

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param \App\Model\Response\ResponseModelInterface $model
     * @param bool $success
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function apply(ResponseModelInterface $model, bool $success): JsonResponse
    {
        $baseResponseModel = new BaseResponseModel();
        $baseResponseModel->setData($model->toArray());
        $baseResponseModel->setSuccess($success);
        $response = new JsonResponse($baseResponseModel->toArray(), $this->getStatusCode($model));
        $response->headers->add(['Content-Type' => $this->getContentType()]);

        return $response;
    }

    /**
     * @param \App\Model\Response\ResponseModelInterface $model
     *
     * @return int
     */
    private function getStatusCode(ResponseModelInterface $model): int
    {
        return !empty($model) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;
    }
}
