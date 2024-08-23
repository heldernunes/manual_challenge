<?php

namespace App\Tests\Unit\Service;

use App\Exceptions\InvalidArgumentsException;
use App\Model\Request\BaseReqModel;
use App\Model\Request\RequestCollectionModel;
use App\Service\ValidatorService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationServiceTest extends TestCase
{
    private ValidatorInterface $validator;
    private ValidatorService $validationService;

    protected function setUp(): void
    {
        $this->validator = $this->getMockBuilder(ValidatorInterface::class)
        ->getMock();
        $this->validationService = new ValidatorService($this->validator);
    }

    #[Covers('validateRequestModel')]
    public function testValidateRequestModelThrowsExceptionWhenModelHasErrors()
    {
        $model = new BaseReqModel();
        $errorReturned = new ConstraintViolationList();
        $errorReturned->add(new ConstraintViolation("Error", null, [], null, null, null));

        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($model)
            ->willReturn($errorReturned);

        $this->expectException(InvalidArgumentsException::class);
        $this->validationService->validateRequestModel($model);
    }

    #[Covers('validateRequestModels')]
    public function testValidateRequestModelsThrowsExceptionWhenModelHasErrors()
    {
        $model = new BaseReqModel();
        $errorReturned = new ConstraintViolationList();
        $errorReturned->add(new ConstraintViolation("Error", null, [], null, null, null));

        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($model)
            ->willReturn($errorReturned);

        $this->expectException(InvalidArgumentsException::class);
        $this->validationService->validateRequestModels(new RequestCollectionModel($model));
    }

    #[Covers('validateRequestModel')]
    public function testValidateRequestModelSuccess()
    {
        $model = new BaseReqModel();

        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($model)
            ->willReturn(new ConstraintViolationList());

        $this->validationService->validateRequestModel($model);
    }

    #[Covers('validateRequestModels')]
    public function testValidateRequestModelsSuccess()
    {
        $model = new BaseReqModel();

        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($model)
            ->willReturn(new ConstraintViolationList());

        $this->validationService->validateRequestModels(new RequestCollectionModel($model));
    }
}
