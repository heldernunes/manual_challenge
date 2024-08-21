<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param array $criteria
     *
     * @return array|null
     */
    public function findQuestionnaireQuestionsByQuestionnaireId(array $criteria): ?array
    {
        if (!isset($criteria['questionnaire_id']) || is_null($criteria['questionnaire_id'])) {
            throw new \InvalidArgumentException('The criteria array must contain a valid "questionnaire_id".');
        }

        $query = $this->createQueryBuilder('q')
            ->select('q')
            ->where('q.questionnaireId = :questionnaire_id')
            ->setParameter('questionnaire_id', $criteria['questionnaire_id'])
            ->getQuery();

        return $query->getResult();
    }
}
