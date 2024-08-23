<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use App\Transformer\BaseTransformer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @codeCoverageIgnore
 *
 * @extends ServiceEntityRepository<Questionnaire>
 *
 * @method Questionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questionnaire[]    findAll()
 * @method Questionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questionnaire::class);
    }

    /**
     * @param array $criteria
     *
     * @return \App\Entity\Questionnaire|null
     * @throws \Exception
     */
    public function findQuestionnaireById(array $criteria): ?Questionnaire
    {
        if (empty($criteria)) {
            throw new Exception('Criteria array is empty');
        }

        return $this->findOneBy($criteria);
    }
}
