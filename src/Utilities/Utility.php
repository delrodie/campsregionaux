<?php


namespace App\Utilities;


use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
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
}