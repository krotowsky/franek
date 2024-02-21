<?php

namespace App\Repository;

use App\Entity\VideoReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoReview>
 *
 * @method VideoReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoReview[]    findAll()
 * @method VideoReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoReview::class);
    }

//    /**
//     * @return VideoReview[] Returns an array of VideoReview objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VideoReview
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
