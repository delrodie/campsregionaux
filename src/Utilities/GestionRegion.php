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

    /**
     * Le template de recherche par le matricule
     *
     * @param $region
     * @return string
     */
    public function renderSearch($region)
    {
        switch ($region) {
            case 'ABENGOUROU':
                $render = 'abengourou/index.html.twig';
                break;
            case 'ABIDJAN':
                $render = 'abidjan/index.html.twig';
                break;
            default:
                $render = 'home/index.html.twig';
                break;
        }

        return $render;
    }

    /**
     * Le template d'inscription selon la region
     *
     * @param $region
     * @return string
     */
    public function renderInscription($region)
    {
        switch ($region){
            case 'ABENGOUROU':
                $render = 'abengourou/inscription.html.twig';
                break;
            case 'ABIDJAN':
                $render = 'abidjan/inscription.html.twig';
                break;
            default:
                $render = 'home/index.html.twig';
                break;
        }

        return $render;
    }
}