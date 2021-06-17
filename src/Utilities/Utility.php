<?php


namespace App\Utilities;


use App\Entity\Config;
use App\Entity\Paiement;
use App\Entity\Participant;
use App\Entity\Sygesca\District;
use App\Entity\Sygesca\Region;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Utility
{

    private $entityManager;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    public function listeParticipants()
    {
        $participants = $this->entityManager->getRepository(Participant::class)->findList($this->session->get('region'));

        $listes=[]; $i=0;
        foreach ($participants as $participant){
            $listes[$i++]=[
                'matricule' => $participant->getMatricule(),
                'carte' => $participant->getCarte(),
                'nom' => $participant->getNom(),
                'prenom' => $participant->getPrenom(),
                'sexe' => $participant->getSexe(),
                'fonction' => $participant->getFonction(),
                'montant' => $participant->getActivite()->getMontant(),
                'slug' => $participant->getSlug(),
                'groupe' => $participant->getGroupe()->getParoisse(),
                'district' => $participant->getGroupe()->getDistrict()->getNom(),
                'region' => $participant->getGroupe()->getDistrict()->getRegion()->getNom(),
            ];
        }

        return $listes;
    }

    /**
     * Liste des nouveaux paiements
     * 
     * @param $annee
     * @param $semaine
     * @return array
     */
    public function listeNouveauxParticipant($annee, $semaine)
    {
        $periode = $this->week2str($annee, $semaine);
        $participants = $this->entityManager->getRepository(Paiement::class)
            ->findPeriodeParticipant(
                $this->session->get('region'),
                $periode['debut'],
                $periode['fin']
            );

        $listes=[]; $i=0;
        foreach ($participants as $participant){
            //$config = $this->entityManager->getRepository(Config::class)->findByRegion($participant->getGroupe()->getDistrict()->getRegion()->getId());
            $listes[$i++]=[
                'matricule' => $participant->getMatricule(),
                'carte' => $participant->getCarte(),
                'nom' => $participant->getNom(),
                'prenom' => $participant->getPrenoms(),
                'sexe' => $participant->getSexe(),
                'fonction' => $participant->getFonction(),
                'montant' => $participant->getActivite()->getMontant(),
                'slug' => $participant->getSlug(),
                'groupe' => $participant->getGroupe()->getParoisse(),
                'district' => $participant->getGroupe()->getDistrict()->getNom(),
                'region' => $participant->getGroupe()->getDistrict()->getRegion()->getNom(),
                'regionId' => $participant->getGroupe()->getDistrict()->getRegion()->getId(),
                'statut' => $participant->getStatut(),
                'idTransaction' => $participant->getIdTransaction(),
                'statusPaiement' => $participant->getStatusPaiement(),
                'created' => $participant->getCreatedAt(),
                'paieTelephone' => $participant->getPaieTelephone(),
                //'config_siteId' => $config->getSiteId(),
            ];
        }

        return $listes;
    }


    /**
     * Liste des paiement
     * 
     * @param $statut
     * @return array
     */
    public function listPaiement($statut)
    {
        $participants = $this->entityManager->getRepository(Paiement::class)
            ->findList(
                $this->session->get('region'),
                $statut
            );

        $listes=[]; $i=0;
        foreach ($participants as $participant){
            //$config = $this->entityManager->getRepository(Config::class)->findByRegion($participant->getGroupe()->getDistrict()->getRegion()->getId());
            $listes[$i++]=[
                'matricule' => $participant->getMatricule(),
                'carte' => $participant->getCarte(),
                'nom' => $participant->getNom(),
                'prenom' => $participant->getPrenoms(),
                'sexe' => $participant->getSexe(),
                'fonction' => $participant->getFonction(),
                'montant' => $participant->getActivite()->getMontant(),
                'slug' => $participant->getSlug(),
                'groupe' => $participant->getGroupe()->getParoisse(),
                'district' => $participant->getGroupe()->getDistrict()->getNom(),
                'region' => $participant->getGroupe()->getDistrict()->getRegion()->getNom(),
                'regionId' => $participant->getGroupe()->getDistrict()->getRegion()->getId(),
                'statut' => $participant->getStatut(),
                'idTransaction' => $participant->getIdTransaction(),
                'statusPaiement' => $participant->getStatusPaiement(),
                'created' => $participant->getCreatedAt(),
                'paieTelephone' => $participant->getPaieTelephone(),
                //'config_siteId' => $config->getSiteId(),
            ];
        }

        return $listes;
    }

    public function listByBranche($branche)
    {
        $participants = $this->entityManager->getRepository(Participant::class)
            ->findByBranche(
                $branche,
                $this->session->get('region')
            ); //dd($participants);

        $listes=[]; $i=0;
        foreach ($participants as $participant){
            //$config = $this->entityManager->getRepository(Config::class)->findByRegion($participant->getGroupe()->getDistrict()->getRegion()->getId());
            $listes[$i++]=[
                'matricule' => $participant->getMatricule(),
                'carte' => $participant->getCarte(),
                'nom' => $participant->getNom(),
                'prenom' => $participant->getPrenom(),
                'sexe' => $participant->getSexe(),
                'fonction' => $participant->getFonction(),
                'montant' => $participant->getActivite()->getMontant(),
                'slug' => $participant->getSlug(),
                'groupe' => $participant->getGroupe()->getParoisse(),
                'district' => $participant->getGroupe()->getDistrict()->getNom(),
                'region' => $participant->getGroupe()->getDistrict()->getRegion()->getNom(),
                'regionId' => $participant->getGroupe()->getDistrict()->getRegion()->getId(),
                'statut' => $participant->getStatut(),
                //'idTransaction' => $participant->getIdTransaction(),
                //'statusPaiement' => $participant->getStatusPaiement(),
                'created' => $participant->getCreatedAt(),
                'paieTelephone' => $participant->getPaieTelephone(),
                //'config_siteId' => $config->getSiteId(),
            ];
        }

        return $listes;
    }

    /**
     * Nombre de participant par type
     *
     * @param $type
     * @return int
     */
    public function getNombreByType($type)
    { //dd($type);
        $participants = $this->entityManager->getRepository(Participant::class)
            ->findByType($type, $this->session->get('region')); //dd($participants);

        return count($participants);
    }

    /**
     * Nombre de participants par district
     *
     * @return array
     */
    public function nombreParticipantParDistrict()
    {
        $districts = $this->entityManager->getRepository(District::class)
            ->findByRegion(
                $this->session->get('region')
            );

        $districtList = [];$i=0;
        foreach ($districts as $district){
            $participants = $this->entityManager->getRepository(Participant::class)->findByDistrict($district->getId());

            $districtList[$i++] = [
                'id' => $district->getId(),
                'nom' => $district->getNom(),
                'slug' => $district->getSlug(),
                'participant' => count($participants)
            ];
        }

        return $districtList;
    }

    public function nombreParticipantParRegion()
    {
        $regions = $this->entityManager->getRepository(Region::class)->liste()->getQuery()->getResult();

        $regionList = []; $i=0;
        foreach ($regions as  $region){
            $participants = $this->entityManager->getRepository(Participant::class)->findByRegion($region->getId());

            $regionList[$i++] = [
                'id' => $region->getId(),
                'nom' => $region->getNom(),
                'slug' => $region->getSlug(),
                'participant' => count($participants)
            ];
        }

        return $regionList;
    }

    /**
     * Les branches
     *
     * @return string[]
     */
    public function branche()
    {
        $branche = [
            'louveteau' => "LOUVETEAU (8 - 11 ANS)",
            'eclaireur' => "ECLAIREUR (12 - 14 ANS)",
            'cheminot' => "CHEMINOT (15 - 17 ANS)",
            'routier' => "ROUTIER (18 - 21 ANS)"
        ];

        return $branche;
    }

    /**
     * Retourne une semaine sous forme de chaine "du {lundi} au {dimanche}..." en gérant des cas particuliers :
     *  - début et fin pas dans le même mois
     *  - début et fin pas dans la même année
     * !!! Penser à utiliser setlocale pour avoir la date (jour et mois) en Français !!!
     */
    function week2str($annee, $no_semaine){
        // Récup jour début et fin de la semaine
        $timeStart = strtotime("First Monday January {$annee} + ".($no_semaine - 1)." Week");
        $timeEnd   = strtotime("First Monday January {$annee} + {$no_semaine} Week -1 day");


        $dateDebut = strftime("%Y-%m-%d 00:00:00", $timeStart);
        $dateFin = strftime("%Y-%m-%d 23:59:59", $timeEnd);

        $periode = [
            'debut' => $dateDebut,
            'fin' => $dateFin
        ];
        return $periode;
    }
}