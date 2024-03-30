<?php

namespace App\Repository;

use App\Entity\MyFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MyFile>
 *
 * @method MyFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyFile[]    findAll()
 * @method MyFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyFile::class);
    }

//    /**
//     * @return MyFile[] Returns an array of MyFile objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MyFile
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
