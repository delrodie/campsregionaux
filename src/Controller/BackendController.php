<?php

namespace App\Controller;

use App\Entity\User;
use App\Utilities\Security;
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

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="backend_dashboard")
     */
    public function index(): Response
    {
        $regionSession = $this->session->get('region');

        return $this->redirectToRoute('backend_participant_index');
        /*
        return $this->render('backend/index.html.twig', [
            'controller_name' => 'BackendController',
        ]); */
    }
}
