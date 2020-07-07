<?php

namespace App\Repository;

use App\Entity\ArmourClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArmourClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmourClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmourClass[]    findAll()
 * @method ArmourClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmourClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmourClass::class);
    }

    // /**
    //  * @return ArmourClass[] Returns an array of ArmourClass objects
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
    public function findOneBySomeField($value): ?ArmourClass
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
