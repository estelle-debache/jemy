<?php

namespace App\Repository;

use App\Entity\Recuperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Recuperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recuperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recuperation[]    findAll()
 * @method Recuperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecuperationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recuperation::class);
    }

//    /**
//     * @return Recuperation[] Returns an array of Recuperation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recuperation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    

    
}
