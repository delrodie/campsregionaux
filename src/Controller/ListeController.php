<?php

namespace App\Controller;

use App\Entity\Sygesca\District;
use App\Utilities\GestionRegion;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("backend/liste")
 */
class ListeController extends AbstractController
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
     * @Route("/", name="backend_liste_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $district = $request->get('district');
        if ($district){
            $listes = $this->utility->listeByDistrict($district);
            $title = "Liste ".$this->getDoctrine()->getRepository(District::class)->findOneBy(['id'=>$district])->getNom();

        }else{
            $listes = $this->utility->listeParticipants();
            $title = "Liste globale des participants";

        }

        if ($this->session->get('region')) $districts = $this->utility->nombreParticipantParDistrict();
        else $districts = $this->getDoctrine()->getRepository(District::class)->findBy([],['nom'=>"ASC"]);

        return $this->render('liste/index.html.twig', [
            'listes' => $listes,
            'title' => $title,
            'districts' => $districts,
        ]);
    }
}
