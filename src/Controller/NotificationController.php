<?php

namespace App\Controller;

use App\Entity\Config;
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

    /**
     * @Route("/liste", name="app_notification_liste", methods={"GET"})
     */
    public function liste(): Response
    {
        $listes = $this->utility->listeNouveauxParticipant(date('Y'),date('W'));
        $nombre = count($listes);
        $periode = $this->utility->week2str(date('Y'),date('W'));
        $today = date('Y-m-d');

        // Utilisateur administrateur
        if (!$this->session->get('region')){
            return $this->render('notification/liste_admin.html.twig', [
                'listes' => $listes,
                'nombre' => $nombre,
                'periode' => $periode,
                'aujourdhui' => $today
            ]);
        }

        return $this->render('notification/liste.html.twig', [
            'listes' => $listes,
            'nombre' => $nombre,
            'periode' => $periode,
            'aujourdhui' => $today
        ]);
    }

}
