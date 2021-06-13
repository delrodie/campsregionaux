<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    /**
     * @param $matricule
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getBadge($matricule)
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
            ->where('p.matricule = :matricule')
            ->setParameter('matricule', $matricule)
            ->getQuery()->getOneOrNullResult()
            ;
    }

    public function findList($region=null)
    {
        $query = $this->getList();
        if ($region){
            $query->where('r.id = :region')
                ->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
                ->setParameter('region', $region)
                ;
        }else{
            $query->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
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
            ->leftJoin('g.district', 'd');
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
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
    public function findOneBySomeField($value): ?Participant
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
