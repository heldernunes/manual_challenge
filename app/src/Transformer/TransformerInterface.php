<?php

namespace App\Transformer;

use App\Model\Response\ResponseModelInterface;
use App\Model\Response\ThrottleResponseModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore
 */
interface TransformerInterface
{
    /**
     * @param \App\Model\Response\ResponseModelInterface $model
     * @param bool $success
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function apply(ResponseModelInterface $model, bool $success): JsonResponse;
}
