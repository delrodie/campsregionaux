<?php

namespace App\Repository;

use App\Entity\Paiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Paiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paiement[]    findAll()
 * @method Paiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paiement::class);
    }

    /**
     * Liste des paiements selon la periode
     * 
     * @param null $region
     * @param $debut
     * @param $fin
     * @return int|mixed|string
     */
    public function findPeriodeParticipant($region=null, $debut, $fin)
    {
        $query = $this->getList();
        if ($region){
            $query->where('r.id = :region')
                ->andWhere('p.createdAt BETWEEN :debut AND :fin')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameters([
                    'region' => $region,
                    'debut' => $debut,
                    'fin' => $fin
                ])
            ;
        }else{
            $query
                ->where('p.createdAt BETWEEN :debut AND :fin')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameters([
                    'debut' => $debut,
                    'fin' => $fin
                ])
            ;
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Liste des paiements selon le statut
     *
     * @param null $region
     * @param null $statut
     * @return int|mixed|string
     */
    public function findList($region=null, $statut=null)
    {
        $query = $this->getList();
        if ($region){
            $query->where('r.id = :region')
                ->andWhere('p.statusPaiement = :statut')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameters([
                    'region' => $region,
                    'statut' => $statut,
                ])
            ;
        }else{
            $query
                ->where('p.statusPaiement = :statut')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameter('statut', $statut)
            ;
        }

        return $query->getQuery()->getResult();
    }

    public function getList()
    {
        return $this->createQueryBuilder('p')
            ->addSelect('a')
            ->addSelect('r')
            ->addSelect('g')
            ->addSelect('d')
            ->leftJoin('p.activite', 'a')
            ->leftJoin('a.region', 'r')
            ->leftJoin('p.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ;
    }

    // /**
    //  * @return Paiement[] Returns an array of Paiement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Paiement
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
