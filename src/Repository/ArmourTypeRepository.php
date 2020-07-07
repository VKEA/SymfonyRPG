<?php

namespace App\Repository;

use App\Entity\ArmourType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArmourType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmourType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmourType[]    findAll()
 * @method ArmourType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmourTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmourType::class);
    }

    // /**
    //  * @return ArmourType[] Returns an array of ArmourType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArmourType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
