<?php

namespace App\Tests\Unit\Service;

use App\Entity\QuestionAnswerRestriction;
use App\Model\Request\MedicationReqModel;
use App\Repository\AnswerRepository;
use App\Repository\AnswerToProductDosageRepository;
use App\Repository\ProductRepository;
use App\Repository\QuestionAnswerRestrictionRepository;
use App\Service\MedicationService;
use App\Service\Product\ProductExclusionVoter;
use App\Transformer\BaseTransformer;
use Generator;
use PHPUnit\Framework\TestCase;

class MedicationServiceTest extends TestCase
{
    private BaseTransformer $baseTransformer;

    private QuestionAnswerRestrictionRepository $questionAnswerRestrictionRepository;

    private AnswerRepository $answerRepository;

    private ProductRepository $productRepository;

    private AnswerToProductDosageRepository $answerToProductDosageRepository;

    private MedicationService $medicationService;

    private ProductExclusionVoter $productExclusionVoter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseTransformer = new BaseTransformer();
        $this->questionAnswerRestrictionRepository = $this->createMock(QuestionAnswerRestrictionRepository::class);
        $this->answerRepository = $this->createMock(AnswerRepository::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->answerToProductDosageRepository = $this->createMock(AnswerToProductDosageRepository::class);
        $this->productExclusionVoter = new ProductExclusionVoter();

        $this->medicationService = new MedicationService(
            $this->baseTransformer,
            $this->questionAnswerRestrictionRepository,
            $this->productExclusionVoter,
            $this->answerRepository,
            $this->productRepository,
            $this->answerToProductDosageRepository
        );
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('getMedicationByQuestionnaireResponsesProvider')]
    public function testGetMedicationByQuestionnaireResponses(array $content, array $dbMocks, array $expectedResponse): void
    {
        $medicationReqModel = new MedicationReqModel(
            $content['questionnaireId'],
            $content['responses'],
        );
        $this->setDbMocks($dbMocks);

        $response = $this->medicationService->getMedicationByQuestionnaireResponses($medicationReqModel);

        $this->assertEquals($expectedResponse, json_decode($response->getContent(), true));
    }

    public static function getMedicationByQuestionnaireResponsesProvider(): Generator
    {
        yield 'all products excluded' => [
            'content' => [
                'questionnaireId' => 1,
                'responses' => [
                    [
                        'questionId' => 1,
                        'answerId' => 2,
                    ],
                    [
                        'questionId' => 2,
                        'answerId' => 3,
                    ],
                ],
            ],
            'dbMocks' => [
                'findRestrictionsByType' => [
                    self::mockQuestionAnswerRestrictionEntity(1, 2, 'exclude_all', 'Exclusion details'),
                    self::mockQuestionAnswerRestrictionEntity(2, 5, 'exclude_all', 'Exclusion details'),
                ],
                'findDosageIdsByAnswerIds' => [],
                'findProductsByProductDosageIds' => [],
                'findRestrictionsNotByType' => [],
                'findAllProductsWithDosage' => [],
            ],
            'expectedResponse' => [
                'success' => true,
                'data' => [
                    'code' => 404,
                    'description' => 'Exclusion details',
                ],
                'message' => null,
            ],
        ];

        yield 'no products excluded' => [
            'content' => [
                'questionnaireId' => 1,
                'responses' => [
                    [
                        'questionId' => 1,
                        'answerId' => 2,
                    ],
                    [
                        'questionId' => 2,
                        'answerId' => 3,
                    ],
                ],
            ],
            'dbMocks' => [
                'findRestrictionsByType' => [
                    self::mockQuestionAnswerRestrictionEntity(1, 1, 'exclude_all', 'Exclusion details'),
                    self::mockQuestionAnswerRestrictionEntity(2, 5, 'exclude_all', 'Exclusion details'),
                ],
                'findDosageIdsByAnswerIds' => [
                    [
                        'productDosageId' => 1,
                    ],
                ],
                'findProductsByProductDosageIds' => [
                    [
                        [
                            'id' => 1,
                            'category' => 'Category 1',
                            'name' => 'Product 1',
                            'dosage' => 'Dosage 1',
                            'price' => 10,
                        ],
                    ],
                ],
                'findRestrictionsNotByType' => [],
                'findAllProductsWithDosage' => [],
            ],
            'expectedResponse' => [
                'success' => true,
                'data' => [
                    'products' => [
                        [
                            'id' => 1,
                            'category' => 'Category 1',
                            'name' => 'Product 1 Dosage 1',
                            'price' => 10,
                        ],
                    ],
                ],
                'message' => null,
            ],
        ];

        yield 'products partially excluded' => [
            'content' => [
                'questionnaireId' => 1,
                'responses' => [
                    [
                        'questionId' => 1,
                        'answerId' => 2,
                    ],
                    [
                        'questionId' => 2,
                        'answerId' => 3,
                    ],
                ],
            ],
            'dbMocks' => [
                'findRestrictionsByType' => [
                    self::mockQuestionAnswerRestrictionEntity(2, 5, 'exclude_all', 'Exclusion details'),
                ],
                'findDosageIdsByAnswerIds' => [],
                'findProductsByProductDosageIds' => [
                    [
                        [
                            'id' => 1,
                            'category' => 'Category 1',
                            'name' => 'Product 1',
                            'dosage' => 'Dosage 1',
                            'price' => 10,
                        ],
                    ],
                ],
                'findRestrictionsNotByType' => [
                    self::mockQuestionAnswerRestrictionEntity(2, 3, 'exclude_tadalafil', 'Exclude Tadalafil'),
                ],
                'findAnswerAndRestriction' => [
                    [
                        'id' => 3,
                        'productDosageId' => 1,
                        'questionId' => 2,
                        'text' => 'Answer 3',
                        'followUpQuestionId' => null,
                        'productDosageId => 1,',
                        'exclusionType' => 'exclude_tadalafil',
                        'exclusionDetails' => 'Exclude Tadalafil',
                    ],
                ],
                'findAllProductsWithDosage' => [],
            ],
            'expectedResponse' => [
                'success' => true,
                'data' => [
                    'products' => [
                        [
                            'id' => 1,
                            'category' => 'Category 1',
                            'name' => 'Product 1 Dosage 1',
                            'price' => 10,
                        ],
                    ],
                ],
                'message' => null,
            ],
        ];

        yield 'all products available' => [
            'content' => [
                'questionnaireId' => 1,
                'responses' => [
                    [
                        'questionId' => 1,
                        'answerId' => 2,
                    ],
                    [
                        'questionId' => 2,
                        'answerId' => 3,
                    ],
                ],
            ],
            'dbMocks' => [
                'findRestrictionsByType' => [
                    self::mockQuestionAnswerRestrictionEntity(1, 1, 'exclude_all', 'Exclusion details'),
                    self::mockQuestionAnswerRestrictionEntity(2, 5, 'exclude_all', 'Exclusion details'),
                ],
                'findDosageIdsByAnswerIds' => [
                    [],
                ],
                'findProductsByProductDosageIds' => [],
                'findRestrictionsNotByType' => [],
                'findAllProductsWithDosage' => [
                    [
                        'id' => 1,
                        'category' => 'Category 1',
                        'name' => 'Product 1',
                        'dosage' => 'Dosage 1',
                        'price' => 10,
                    ],
                    [
                        'id' => 2,
                        'category' => 'Category 2',
                        'name' => 'Product 2',
                        'dosage' => 'Dosage 2',
                        'price' => 20,
                    ],
                ],
            ],
            'expectedResponse' => [
                'success' => true,
                'data' => [
                    'products' => [
                        [
                            'id' => 1,
                            'category' => 'Category 1',
                            'name' => 'Product 1 Dosage 1',
                            'price' => 10,
                        ],
                        [
                            'id' => 2,
                            'category' => 'Category 2',
                            'name' => 'Product 2 Dosage 2',
                            'price' => 20,
                        ]
                    ],
                ],
                'message' => null,
            ],
        ];
    }

    private static function mockQuestionAnswerRestrictionEntity(
        int    $id,
        int    $answerId,
        string $exclusionType,
        string $exclusionDetails
    ): QuestionAnswerRestriction
    {
        return (new QuestionAnswerRestriction())
            ->setId($id)
            ->setAnswerId($answerId)
            ->setExclusionType($exclusionType)
            ->setExclusionDetails($exclusionDetails);
    }

    private function setDbMocks(array $dbMocks)
    {
        $this->questionAnswerRestrictionRepository->expects(self::once())
            ->method('findRestrictionsByType')
            ->willReturn($dbMocks['findRestrictionsByType']);

        $this->answerToProductDosageRepository->expects(self::exactly($dbMocks['findDosageIdsByAnswerIds'] ? 1 : 0))
            ->method('findDosageIdsByAnswerIds')
            ->willReturn($dbMocks['findDosageIdsByAnswerIds']);

        $this->productRepository->expects(self::exactly(count($dbMocks['findProductsByProductDosageIds'])))
            ->method('findProductsByProductDosageIds')
            ->willReturnOnConsecutiveCalls(...$dbMocks['findProductsByProductDosageIds']);

        $this->questionAnswerRestrictionRepository->expects(self::any())
            ->method('findRestrictionsNotByType')
            ->willReturn($dbMocks['findRestrictionsNotByType']);

        $this->productRepository->expects(self::exactly($dbMocks['findAllProductsWithDosage'] ? 1 : 0))
            ->method('findAllProductsWithDosage')
            ->willReturn($dbMocks['findAllProductsWithDosage']);
    }
}
