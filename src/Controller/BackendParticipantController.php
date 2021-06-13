<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(SessionInterface $session, Utility $utility)
    {
        $this->session = $session;
        $this->utility = $utility;
    }

    /**
     * @Route("/", name="backend_participant_index")
     */
    public function index(ParticipantRepository $participantRepository): Response
    {

        return $this->render('backend_participant/index.html.twig', [
            'listes' => $this->utility->listeParticipants(),
        ]);
    }
    

}
