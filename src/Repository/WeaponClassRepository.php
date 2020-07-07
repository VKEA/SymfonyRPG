<?php

namespace App\Repository;

use App\Entity\WeaponClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeaponClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeaponClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeaponClass[]    findAll()
 * @method WeaponClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeaponClass::class);
    }

    // /**
    //  * @return WeaponClass[] Returns an array of WeaponClass objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeaponClass
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
