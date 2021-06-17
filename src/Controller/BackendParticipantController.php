<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use App\Utilities\GestionRegion;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/backend/participant")
 */
class BackendParticipantController extends AbstractController
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
     * @Route("/", name="backend_participant_index")
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        $regionSession = $this->session->get('region');
        if (!$regionSession){
            return $this->render('backend_participant/liste_admin.html.twig',[
                'listes' => $this->utility->listeParticipants()
            ]);
        }

        return $this->render('backend_participant/index.html.twig', [
            'listes' => $this->utility->listeParticipants(),
        ]);
    }

    /**
     * @Route("/{matricule}", name="backend_participant_show", methods={"GET"})
     */
    public function show(Request $request, $matricule)
    {
        $region = $request->get('region');
        $scout = $this->gestionRegion->badge($matricule,$region);

        if ($scout){
            return $this->render('home/badge.html.twig',[
                'scout' => $scout,
            ]);
        }else{
            return $this->render('home/badge_404.html.twig');
        }

    }
    

}
