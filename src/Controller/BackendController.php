<?php

namespace App\Controller;

use App\Entity\User;
use App\Utilities\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend")
 */
class BackendController extends AbstractController
{

    /**
     * @Route("/", name="backend_dashboard")
     */
    public function index(): Response
    {



        //if (!$this->getUser()) return $this->redirectToRoute('app_login');

        return $this->render('backend/index.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }
}
