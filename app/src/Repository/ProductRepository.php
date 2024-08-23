<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductDosage;
use App\Entity\QuestionAnswerRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return array<\App\Entity\Product>
     */
    public function findAllProductsWithDosage(): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p.id', 'c.name as category', 'p.name', 'pd.dosage', 'pd.price')
            ->leftJoin(Category::class, 'c', 'WITH', 'p.categoryId = c.id')
            ->leftJoin(ProductDosage::class, 'pd', 'WITH', 'p.id = pd.productId');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param array $productDosageIds
     *
     * @return array<\App\Entity\Product>
     */
    public function findProductsByProductDosageIds(array $productDosageIds): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p.id', 'c.name as category', 'p.name', 'pd.dosage', 'pd.price')
            ->leftJoin(Category::class, 'c', 'WITH', 'p.categoryId = c.id')
            ->leftJoin(ProductDosage::class, 'pd', 'WITH', 'p.id = pd.productId')
            ->where('pd.id IN (:productDosageIds)')
            ->setParameter('productDosageIds', $productDosageIds);

        return $queryBuilder->getQuery()->getResult();
    }
}
