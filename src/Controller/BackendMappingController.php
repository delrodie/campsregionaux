<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Participant;
use App\Entity\Sygesca\Region;
use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/mapping")
 */
class BackendMappingController extends AbstractController
{
    private $gestionRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/", name="backend_mapping_index")
     */
    public function index(): Response
    {
        $regions = $this->getDoctrine()->getRepository(Region::class)->liste()->getQuery()->getResult(); //dd($regions);
        $liste=[]; $i = 0;
        foreach ($regions as $region){
            $participant = count($this->getDoctrine()->getRepository(Participant::class)->findByRegion($region->getId()));
            $activite = $this->getDoctrine()->getRepository(Activite::class)->findOneBy(['region'=>$region->getId()]);
            $adulte = count($this->getDoctrine()->getRepository(Participant::class)->findByType('Adulte', $region->getId()));
            $jeune = count($this->getDoctrine()->getRepository(Participant::class)->findByType('Jeune', $region->getId()));
            $time_debut = strtotime($activite->getDebut()); $debut = date('d/m/Y', $time_debut);
            $time_fin = strtotime($activite->getFin()); $fin = date('d/m/Y', $time_fin);

            // pluriel
            if ($jeune <= 1) $jeuneText = $jeune." jeune";
            else $jeuneText = $jeune." jeunes";
            if ($adulte <= 1) $adulteText = $adulte." adulte";
            else $adulteText = $adulte." adultes";
            if ($participant <= 1) $participantText = $participant." participant";
            else $participantText = $participant." participants";

            $message = "Denommé ".$activite->getNom().", le camp de vacances de la région de ".$region->getNom().", se tiendra du ".$debut." au ".$fin." à ".$activite->getLieu()." avec ".$participantText.". Dont ".$jeuneText." et ".$adulteText;
            //$message = "Denommé ".$activite->getNom().", le camp de vacances de la région de ".$region->getNom().", se tiendra du ".$debut." au ".$fin." à ".$activite->getLieu();

            if (strtolower($region->getNom()) === 'grand bassam'){
                $liste[$i++] = [
                    'nom' => "bassam",
                    'message' => $message
                ];
            }elseif(strtolower($region->getNom()) === 'san pedro'){
                $liste[$i++] = [
                    'nom' => "sanpedro",
                    'message' => $message
                ];
            }elseif(strtolower($region->getNom()) === 'yamoussoukro'){
                $liste[$i++] = [
                    'nom' => 'yakro',
                    'message' => $message
                ];
            }else{
                $liste[$i++] = [
                    'nom' => strtolower($region->getNom()),
                    'message' => $message
                ];
            }

        } //dd($liste);
        return $this->render('home/index.html.twig', [
            'regions' => $regions,
            'listes' => $liste
        ]);
    }
}
