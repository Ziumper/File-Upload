<?php

namespace App\Repository;

use App\Entity\UploadEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UploadEntry>
 *
 * @method UploadEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadEntry[]    findAll()
 * @method UploadEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadEntry::class);
    }

    //    /**
    //     * @return UploadEntry[] Returns an array of UploadEntry objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UploadEntry
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
