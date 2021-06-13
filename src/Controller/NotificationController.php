<?php

namespace App\Controller;

use App\Utilities\GestionRegion;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notification")
 */
class NotificationController extends AbstractController
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
     * @Route("/", name="app_notification_index")
     */
    public function index(): Response
    {
        $listes = $this->utility->listeNouveauxParticipant(date('Y'),date('W'));
        $nombre = count($listes);

        return $this->render('notification/index.html.twig', [
            'listes' => $listes,
            'nombre' => $nombre
        ]);
    }


}
