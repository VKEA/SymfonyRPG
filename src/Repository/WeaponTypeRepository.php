<?php

namespace App\Repository;

use App\Entity\WeaponType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeaponType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeaponType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeaponType[]    findAll()
 * @method WeaponType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeaponType::class);
    }

    // /**
    //  * @return WeaponType[] Returns an array of WeaponType objects
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
    public function findOneBySomeField($value): ?WeaponType
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
