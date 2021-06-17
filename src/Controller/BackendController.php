<?php

namespace App\Controller;

use App\Entity\Sygesca\District;
use App\Entity\User;
use App\Utilities\GestionRegion;
use App\Utilities\Security;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend")
 */
class BackendController extends AbstractController
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
     * @Route("/", name="backend_dashboard")
     */
    public function index(): Response
    {
        /*
        $regionSession = $this->session->get('region');

        return $this->redirectToRoute('backend_participant_index');
        */

        // Gestion des districts
        $districts = $this->utility->nombreParticipantParDistrict();
        $regions = $this->utility->nombreParticipantParRegion();
        $branche = $this->utility->branche();

        $regionSession = $this->session->get('region');
        if (!$regionSession){
            return $this->render('backend/dashboard_admin.html.twig',[
                'participants' => $this->utility->listPaiement('VALID'),
                'regions' => $regions,
                'jeunes' => $this->utility->getNombreByType('Jeune'),
                'adultes' => $this->utility->getNombreByType('Adulte'),
                'louveteau' => count($this->utility->listByBranche($branche['louveteau'])),
                'eclaireur' => count($this->utility->listByBranche($branche['eclaireur'])),
                'cheminot' => count($this->utility->listByBranche($branche['cheminot'])),
                'routier' => count($this->utility->listByBranche($branche['routier'])),
            ]);
        }

        return $this->render('backend/index.html.twig', [
            'participants' => $this->utility->listPaiement('VALID'),
            'districts' => $districts,
            'jeunes' => $this->utility->getNombreByType('Jeune'),
            'adultes' => $this->utility->getNombreByType('Adulte'),
            'louveteau' => count($this->utility->listByBranche($branche['louveteau'])),
            'eclaireur' => count($this->utility->listByBranche($branche['eclaireur'])),
            'cheminot' => count($this->utility->listByBranche($branche['cheminot'])),
            'routier' => count($this->utility->listByBranche($branche['routier'])),
        ]);
    }
}
