<?php


namespace App\Utilities;


use App\Entity\Sygesca\Region;
use Doctrine\ORM\EntityManagerInterface;

class GestionRegion
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Recuperation des informations sur la Région
     *
     * @param $regionNom
     * @return object|null
     */
    public function getRegion($regionNom): Object
    {
        $region = $this->entityManager->getRepository(Region::class)->findOneBy(['nom' => $regionNom]);
        return $region;
    }
}