<?php


namespace App\Utilities;


use App\Entity\Activite;
use App\Entity\Config;
use App\Entity\Participant;
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
        return $region; //dd($region);
    }

    /**
     * Recherche de la configuration de la region
     *
     * @param $region
     * @return array
     */
    public function getConfig($region)
    {
        $config = $this->entityManager->getRepository(Config::class)->findOneBy(['region'=>$region]); //dd($region);

        return $value = [
            'rgb' => $config->getCouleurRGB(),
            'theme' => $config->getCouleurTheme(),
            'bg' => $config->getBg(),
        ];
    }

    public function badge($matricule, $region)
    {
        $participation = $this->entityManager->getRepository(Participant::class)->getBadge($matricule, $region);

        if($participation){
            $config = $this->entityManager->getRepository(Config::class)->findOneBy(['region'=>$participation->getActivite()->getRegion()->getId()]);

            $scout = [
                'activite' => $participation->getActivite()->getNom(),
                'identite' => $participation->getNom().' '.$participation->getPrenom(),
                'fonction' => $participation->getFonction(),
                'matricule' => $participation->getMatricule(),
                'carte' => $participation->getCarte(),
                'sexe' => $participation->getSexe(),
                'district' => $participation->getGroupe()->getDistrict()->getNom(),
                'groupe' => $participation->getGroupe()->getParoisse(),
                'urgence' => $participation->getContacturgence(),
                'parent' => $participation->geturgence(),
                'region' => $participation->getActivite()->getRegion()->getNom(),
                'region_id' => $participation->getActivite()->getRegion()->getId(),
                'config_couleurTheme' => $config->getCouleurTheme(),
                'config_couleurRGB' => $config->getCouleurRGB(),
                'config_bg' => $config->getBg(),
                'config_logo' => $config->getLogoRegion()
            ];
        }else{
            $scout = [];
        }

        return $scout;

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
                $render = 'bassam/index.html.twig';
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
                $render = 'yakro/index.html.twig';
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
                $render = 'bassam/inscription.html.twig';
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
                $render = 'yakro/inscription.html.twig';
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

    /**
     * Le template de badge
     *
     * @param $region
     * @return string
     */
    public function renderBadge($region)
    {
        switch ($region){
            case 'ABENGOUROU':
                $render = 'abengourou/search_badge.html.twig';
                break;
            case 'ABIDJAN':
                $render = 'abidjan/search_badge.html.twig';
                break;
            case 'AGBOVILLE':
                $render = 'agboville/search_badge.html.twig';
                break;
            case 'BONDOUKOU':
                $render = 'bondoukou/search_badge.html.twig';
                break;
            case 'BOUAKE':
                $render = 'bouake/search_badge.html.twig';
                break;
            case 'DALOA':
                $render = 'daloa/search_badge.html.twig';
                break;
            case 'GAGNOA':
                $render = 'gagnoa/search_badge.html.twig';
                break;
            case 'GRAND BASSAM':
                $render = 'bassam/search_badge.html.twig';
                break;
            case 'KATIOLA':
                $render = 'katiola/search_badge.html.twig';
                break;
            case 'KORHOGO':
                $render = 'korhogo/search_badge.html.twig';
                break;
            case 'MAN':
                $render = 'man/search_badge.html.twig';
                break;
            case 'ODIENNE':
                $render = 'odienne/search_badge.html.twig';
                break;
            case 'SAN PEDRO':
                $render = 'sanpedro/search_badge.html.twig';
                break;
            case 'YAMOUSSOUKRO':
                $render = 'yakro/search_badge.html.twig';
                break;
            case 'YOPOUGON':
                $render = 'yopougon/search_badge.html.twig';
                break;
            default:
                $render = 'badge/index.html.twig';
                break;
        }

        return $render;
    }
    /**
     * Le template de badge
     *
     * @param $region
     * @return string
     */
    public function url($region)
    {
        switch ($region){
            case 'ABENGOUROU':
                $render = ['frontend'=>'abengourou_index', 'backend'=>'backend_abengourou_index'];
                break;
            case 'ABIDJAN':
                $render = ['frontend'=>'abidjan_index', 'backend'=>'backend_abidjan_index'];
                break;
            case 'AGBOVILLE':
                $render = ['frontend'=>'agboville_index', 'backend'=>'backend_agboville_index'];
                break;
            case 'BONDOUKOU':
                $render = ['frontend'=>'bondoukou_index', 'backend'=>'backend_bondoukou_index'];
                break;
            case 'BOUAKE':
                $render = ['frontend'=>'bouake_index', 'backend'=>'backend_bouake_index'];
                break;
            case 'DALOA':
                $render = ['frontend'=>'daloa_index', 'backend'=>'backend_daloa_index'];
                break;
            case 'GAGNOA':
                $render = ['frontend'=>'gagnoa_index', 'backend'=>'backend_gagnoa_index'];
                break;
            case 'GRAND BASSAM':
                $render = ['frontend'=>'bassam_index', 'backend'=>'backend_bassam_index'];
                break;
            case 'KATIOLA':
                $render = ['frontend'=>'katiola_index', 'backend'=>'backend_katiola_index'];
                break;
            case 'KORHOGO':
                $render = ['frontend'=>'korhogo_index', 'backend'=>'backend_korhogo_index'];
                break;
            case 'MAN':
                $render = ['frontend'=>'man_index', 'backend'=>'backend_man_index'];
                break;
            case 'ODIENNE':
                $render = ['frontend'=>'odienne_index', 'backend'=>'backend_odienne_index'];
                break;
            case 'SAN PEDRO':
                $render = ['frontend'=>'sanpedro_index', 'backend'=>'backend_sanpedro_index'];
                break;
            case 'YAMOUSSOUKRO':
                $render = ['frontend'=>'yakro_index', 'backend'=>'backend_yakro_index'];
                break;
            case 'YOPOUGON':
                $render = ['frontend'=>'yopougon_index', 'backend'=>'backend_yopougon_index'];
                break;
            default:
                $render = ['frontend'=>'app_home', 'backend'=>'backend_dashboard'];
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