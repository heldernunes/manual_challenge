<?php

namespace App\Repository;

use App\Entity\AnswerToProductDosage;
use App\Entity\QuestionAnswerRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 *
 * @extends ServiceEntityRepository<AnswerToProductDosage>
 *
 * @method AnswerToProductDosage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerToProductDosage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerToProductDosage[]    findAll()
 * @method AnswerToProductDosage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerToProductDosageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnswerToProductDosage::class);
    }

    public function findDosageIdsByAnswerIds(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('atpd')
            ->select('atpd.productDosageId')
            ->leftJoin(QuestionAnswerRestriction::class, 'qar', 'WITH', 'qar.answerId = atpd.answerId')
            ->where('atpd.answerId IN (:criteria)')
            ->setParameter('criteria', $criteria);

        return $queryBuilder->getQuery()->getResult();
    }
}
