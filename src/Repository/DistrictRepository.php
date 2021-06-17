<?php


namespace App\Repository;


use App\Entity\Sygesca\District;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method District|null find($id, $lockMode = null, $lockVersion = null)
 * @method District|null findOneBy(array $criteria, array $orderBy = null)
 * @method District[]    findAll()
 * @method District[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistrictRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, District::class);
    }

    /**
     * @param $region
     * @return int|mixed|string
     */
    public function findByRegion($region)
    {
        return $this->createQueryBuilder('d')
            ->where('d.region = :region')
            ->orderBy('d.nom', "ASC")
            ->setParameter('region', $region)
            ->getQuery()->getResult()
            ;
    }

}