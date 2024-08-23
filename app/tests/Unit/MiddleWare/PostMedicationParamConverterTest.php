<?php

namespace App\Tests\Unit\MiddleWare;

use App\Middleware\PostMedicationParamConverter;
use App\Service\ValidatorService;
use App\Tests\Helper\Faker;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class PostMedicationParamConverterTest extends TestCase
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
        $paramConverter = new PostMedicationParamConverter($this->validator);
        $configuration = new ParamConverter(['name' => PostMedicationParamConverter::PARAM_CONVERTER_NAME]);
        $questionnaireId = Faker::integer(1, 10);
        $request = new Request(content: json_encode(['questionnaireId' => $questionnaireId, 'responses' => []]));
        $this->assertTrue($paramConverter->apply($request, $configuration));
    }
}
