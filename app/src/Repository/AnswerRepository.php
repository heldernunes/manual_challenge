<?php

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\AnswerToProductDosage;
use App\Entity\QuestionAnswerRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Answer>
 *
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @param array $criteria
     *
     * @return array<\App\Entity\Answer>
     */
    public function findQuestionnaireAnswersByQuestionIds(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('a.id', 'a.questionId', 'a.text', 'a.followUpQuestionId')
            ->where('a.questionId IN (:criteria)')
            ->setParameter('criteria', $criteria);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAnswerAndRestriction(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select(
                'a.id',
                'a.questionId',
                'a.text',
                'a.followUpQuestionId',
                'atpd.productDosageId',
                'qar.exclusionType',
                'qar.exclusionDetails'
            )->leftJoin(QuestionAnswerRestriction::class, 'qar', 'WITH', 'a.id = qar.answerId')
            ->leftJoin(AnswerToProductDosage::class, 'atpd', 'WITH', 'a.id = atpd.answerId')
            ->where('a.id IN (:criteria)')
            ->setParameter('criteria', $criteria);

        return $queryBuilder->getQuery()->getResult();
    }
}
