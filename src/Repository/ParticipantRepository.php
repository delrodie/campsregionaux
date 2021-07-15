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
    public function getBadge($matricule, $region)
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
            ->andWhere('r.slug = :region')
            ->setParameters([
                'matricule' => $matricule,
                'region' => $region
        ])
            ->getQuery()->getOneOrNullResult()
            ;
    }

    /**
     * Liste des participants par Region
     * @param null $region
     * @return int|mixed|string
     */
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

    public function findByType($type, $region=null, $district=null)
    { //dd($district);
        $query = $this->getList();
        if ($region && !$district){
            $query->where('r.id = :region')
                ->andWhere('t.libelle = :type')
                ->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
                ->setParameters([
                    'region' => $region,
                    'type' => $type
                ])
            ;
        }elseif ($district){
            $query->where('d.id = :district')
                ->andWhere('t.libelle = :type')
                ->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
                ->setParameters([
                    'district' => $district,
                    'type' => $type
                ])
            ;
        }
        else{
            $query->where('t.libelle = :type')
                ->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
                ->setParameter('type', $type)
            ;
        }

        return $query->getQuery()->getResult();
    }

    public function findByBranche($branche, $region=null)
    {
        $query = $this->getList();
        if ($region){
            $query->where('r.id = :region')
                ->andWhere('p.fonction = :branche')
                ->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
                ->setParameters([
                    'region' => $region,
                    'branche' => $branche
                ])
            ;
        }else{
            $query->where('p.fonction = :branche')
                ->orderBy('p.nom', 'ASC')
                ->addOrderBy('p.prenom', 'ASC')
                ->setParameter('branche', $branche)
            ;
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Liste par district
     *
     * @param $district
     * @return int|mixed|string
     */
    public function findByDistrict($district)
    {
        $query = $this->getList()
            ->where('d.id = :district')
            ->setParameter('district', $district)
            ->orderBy('p.nom', "ASC")
            ->addOrderBy('p.prenom', "ASC")
            ->getQuery()->getResult()
            ;

        return $query;
    }

    public function findByRegion($region)
    {
        $query = $this->getList()
            ->where('r.id = :region')
            ->setParameter('region', $region)
            ->orderBy('p.nom', "ASC")
            ->addOrderBy('p.prenom', "ASC")
            ->getQuery()->getResult()
        ;

        return $query;
    }


    public function getList()
    {
        return $this->createQueryBuilder('p')
            ->addSelect('a')
            ->addSelect('r')
            ->addSelect('g')
            ->addSelect('d')
            ->addSelect('t')
            ->leftJoin('p.activite', 'a')
            ->leftJoin('a.region', 'r')
            ->leftJoin('p.groupe', 'g')
            ->leftJoin('g.district', 'd')
            ->leftJoin('p.type', 't');
    }

    /**
     * Liste par district
     *
     * @param $district
     * @return int|mixed|string
     */
    public function findListByDistrict($district)
    {
        $query = $this->getList()
            ->where('d.id = :district')
            ->setParameter('district', $district)
            ->orderBy('p.createdAt', "ASC")
            ->getQuery()->getResult()
        ;

        return $query;
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
