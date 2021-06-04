<?php


namespace App\Utilities;


use App\Entity\Activite;
use App\Entity\Config;
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
        return $region; dd($region);
    }

    /**
     * Recherche de la configuration de la region
     *
     * @param $region
     * @return array
     */
    public function getConfig($region)
    {
        $config = $this->entityManager->getRepository(Config::class)->findOneBy(['region'=>$region]);

        return $value = [
            'rgb' => $config->getCouleurRGB(),
            'theme' => $config->getCouleurTheme(),
            'bg' => $config->getBg(),
        ];
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
            case 'AGBOVILLE':
                $render = 'agboville/index.html.twig';
                break;
            case 'BONDOUKOU':
                $render = 'bondoukou/index.html.twig';
                break;
            case 'BOUAKE':
                $render = 'bouake/index.html.twig';
                break;
            case 'DALOA':
                $render = 'daloa/index.html.twig';
                break;
            case 'GAGNOA':
                $render = 'gagnoa/index.html.twig';
                break;
            case 'GRAND BASSAM':
                $render = 'bassm/index.html.twig';
                break;
            case 'KATIOLA':
                $render = 'katiola/index.html.twig';
                break;
            case 'KORHOGO':
                $render = 'korhogo/index.html.twig';
                break;
            case 'MAN':
                $render = 'man/index.html.twig';
                break;
            case 'ODIENNE':
                $render = 'odienne/index.html.twig';
                break;
            case 'SAN PEDRO':
                $render = 'sanpedro/index.html.twig';
                break;
            case 'YAMOUSSOUKRO':
                $render = 'yako/index.html.twig';
                break;
            case 'YOPOUGON':
                $render = 'yopougon/index.html.twig';
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
            case 'AGBOVILLE':
                $render = 'agboville/inscription.html.twig';
                break;
            case 'BONDOUKOU':
                $render = 'bondoukou/inscription.html.twig';
                break;
            case 'BOUAKE':
                $render = 'bouake/inscription.html.twig';
                break;
            case 'DALOA':
                $render = 'daloa/inscription.html.twig';
                break;
            case 'GAGNOA':
                $render = 'gagnoa/inscription.html.twig';
                break;
            case 'GRAND BASSAM':
                $render = 'bassm/inscription.html.twig';
                break;
            case 'KATIOLA':
                $render = 'katiola/inscription.html.twig';
                break;
            case 'KORHOGO':
                $render = 'korhogo/inscription.html.twig';
                break;
            case 'MAN':
                $render = 'man/inscription.html.twig';
                break;
            case 'ODIENNE':
                $render = 'odienne/inscription.html.twig';
                break;
            case 'SAN PEDRO':
                $render = 'sanpedro/inscription.html.twig';
                break;
            case 'YAMOUSSOUKRO':
                $render = 'yako/inscription.html.twig';
                break;
            case 'YOPOUGON':
                $render = 'yopougon/inscription.html.twig';
                break;
            default:
                $render = 'home/index.html.twig';
                break;
        }

        return $render;
    }

    public function montantParticipation($region)
    {
        $activite = $this->entityManager->getRepository(Activite::class)->findOneBy(['region'=>$region], ['id'=>"DESC"]);
        $montant = (int)$activite->getMontant()/(1-0.035);

        return $this->arrondiSuperieur($montant,5);

    }

    /**
     * Fonction pour arrondir au supérieur
     *
     * @param $nombre
     * @param $arrondi
     * @return float|int
     */
    public function arrondiSuperieur($nombre, $arrondi)
    {
        return ceil($nombre / $arrondi) * $arrondi;
    }
}