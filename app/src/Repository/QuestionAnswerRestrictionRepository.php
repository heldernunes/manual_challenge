<?php

namespace App\Repository;

use App\Entity\QuestionAnswerRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionAnswerRestriction>
 *
 * @method QuestionAnswerRestriction|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionAnswerRestriction|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionAnswerRestriction[]    findAll()
 * @method QuestionAnswerRestriction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionAnswerRestrictionRepository extends ServiceEntityRepository
{
    public const RESTRICTION_TYPE_EXCLUDE_ALL = 'exclude_all';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionAnswerRestriction::class);
    }

    /**
     * @return \App\Entity\QuestionAnswerRestriction[]
     */
    public function findRestrictionsByType(array $criteria): array
    {
        return $this->findBy($criteria);
    }

    /**
     * @return \App\Entity\QuestionAnswerRestriction[]
     */
    public function findRestrictionsNotByType(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('qar')
            ->select('qar')
            ->where('qar.exclusionType NOT IN (:criteria)')
            ->setParameter('criteria', $criteria);

        return $queryBuilder->getQuery()->getResult();
    }
}
