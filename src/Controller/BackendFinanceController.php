<?php

namespace App\Controller;

use App\Entity\Sygesca\District;
use App\Entity\Sygesca\Region;
use App\Utilities\GestionRegion;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/finance")
 */
class BackendFinanceController extends AbstractController
{
    private $session;
    private $utility;
    private $gestionRegion;

    public function __construct(SessionInterface $session, Utility $utility, GestionRegion $gestionRegion)
    {
        $this->session = $session;
        $this->utility = $utility;
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/", name="backend_finance_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $regionSession = $this->session->get('region');
        if (!$regionSession){
            $region = $request->get('region');
            if ($region){
                $listes = $this->utility->listeParticipants($region);
                $title = "Liste ".$this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$region])->getNom();
            }else{
                $listes = $this->utility->listeParticipants();
                $title = "Montant glabal des participants";
            }

            // Recherche du montant global
            $montant=0;
            foreach ($listes as $liste){ //dd($liste);
                $montant = $montant +(int)$liste['montant'];
            }

            return $this->render('backend_finance/liste_admin.html.twig',[
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->liste()->getQuery()->getResult(),
                'title' => $title,
                'montant' => $montant
            ]);
        }

        $district = $request->get('district');
        if ($district){
            $listes = $this->utility->listeParticipantByDistrict($district);
            $title = "Liste ".$this->getDoctrine()->getRepository(District::class)->findOneBy(['id'=>$district])->getNom();
        }else{
            $listes = $this->utility->listeParticipants();
            $title = "Montant global des participants";
        }

        // Recherche du montant global
        $montant=0;
        foreach ($listes as $liste){ //dd($liste);
            $montant = $montant +(int)$liste['montant'];
        }

        return $this->render('backend_finance/index.html.twig', [
            'listes' => $listes,
            'districts' => $this->utility->nombreParticipantParDistrict(),
            'title' => $title,
            'montant' => $montant
        ]);
    }
}
