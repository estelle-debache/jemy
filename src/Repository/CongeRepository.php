<?php

namespace App\Repository;

use App\Entity\Conge;
use App\Entity\Entreprise;
use App\Entity\Salarie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Conge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conge[]    findAll()
 * @method Conge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Conge::class);
    }

    public function countByStatusAndSalarie(Salarie $salarie, $statut = 'En cours', $typeconge = 'Congé payé' )
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb
                // select count(*) from conges
            ->select('count(c)')
                //where statut = statut enregistree en parametre
            ->andWhere('c.statut = :statut')
                // recupere le salarie a parametrer lors de l'appel de la methode
            ->andWhere('IDENTITY(c.salarie) = :salarie')
                
            ->andWhere('c.typeconge = :typeconge')
                // equivalent au bindvalue
            ->setParameters([
                'statut' => $statut,
                'salarie' => $salarie->getId(),
                'typeconge' => $typeconge
            ])
        ;
        
        return $qb->getQuery()->getSingleScalarResult();
    }
    
    public function findAllcongesByEntreprise(Entreprise $entreprise, $statut= 'en cours')
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb
            ->join('c.salarie', 's')
            ->join('s.entreprise', 'e', 'WITH', 'e.id = :id')
            ->andWhere('c.statut = :statut')
            ->setParameters(
                    [
                        'statut' => $statut,
                        'id'=>$entreprise->getId()
                        
                    ]
                    )
        ;
        
        return $qb->getQuery()->getResult();
        
        
    }
    public function countAllcongesByEntreprise(Entreprise $entreprise, $statut= 'en cours')
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb
            ->select('count(c)')
            ->join('c.salarie', 's')
            ->join('s.entreprise', 'e', 'WITH', 'e.id = :id')
            ->andWhere('c.statut = :statut')
            ->setParameters(
                    [
                        'statut' => $statut,
                        'id'=>$entreprise->getId()
                        
                    ]
                    )
        ;
        
        return $qb->getQuery()->getSingleScalarResult();
        
        
    }
    
    
//    /**
//     * @return Conge[] Returns an array of Conge objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Conge
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
