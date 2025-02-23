<?php

namespace App\Repository;

use App\Entity\Symfdata1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Symfdata1>
 *
 * @method Symfdata1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Symfdata1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Symfdata1[]    findAll()
 * @method Symfdata1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Symfdata1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Symfdata1::class);
    }

//    /**
//     * @return Symfdata1[] Returns an array of Symfdata1 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Symfdata1
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
