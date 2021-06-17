<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sygesca\District;
use App\Entity\Sygesca\Region;
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
     * @Route("/", name="backend_participant_index", methods={"GET","POST"})
     */
    public function index(Request $request, ParticipantRepository $participantRepository): Response
    {
        $regionSession = $this->session->get('region');
        if (!$regionSession){
            $region = $request->get('region');
            if ($region){
                $listes = $this->utility->listeParticipants($region);
                $title = "Liste ".$this->getDoctrine()->getRepository(Region::class)->findOneBy(['id'=>$region])->getNom();
            }else{
                $listes = $this->utility->listeParticipants();
                $title = "Liste globale des participants";
            }

            return $this->render('backend_participant/liste_admin.html.twig',[
                'listes' => $listes,
                'regions' => $this->getDoctrine()->getRepository(Region::class)->liste()->getQuery()->getResult(),
                'title' => $title
            ]);
        }

        $district = $request->get('district');
        if ($district){
            $listes = $this->utility->listeParticipantByDistrict($district);
            $title = "Liste ".$this->getDoctrine()->getRepository(District::class)->findOneBy(['id'=>$district])->getNom();
        }else{
            $listes = $this->utility->listeParticipants();
            $title = "Liste globale des participants";
        }

        return $this->render('backend_participant/index.html.twig', [
            'listes' => $listes,
            'districts' => $this->utility->nombreParticipantParDistrict(),
            'title' => $title
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
