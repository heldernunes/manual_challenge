<?php

namespace App\Tests\Unit\Middleware;

use App\Middleware\GetQuestionnaireParamConverter;
use App\Service\ValidatorService;
use App\Tests\Helper\Faker;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class GetQuestionnaireParamConverterTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new ValidatorService(
            Validation::createValidatorBuilder()->enableAnnotationMapping(true)->getValidator()
        );
    }

    public function testApplySuccessFunction()
    {
        $paramConverter = new GetQuestionnaireParamConverter($this->validator);
        $configuration = new ParamConverter(['name' => GetQuestionnaireParamConverter::PARAM_CONVERTER_NAME]);
        $request = new Request(attributes: ['id' => Faker::integer(1, 10)]);
        $this->assertTrue($paramConverter->apply($request, $configuration));
    }
}
