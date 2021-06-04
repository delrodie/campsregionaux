<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Sygesca\District;
use App\Entity\Sygesca\Region;
use App\Entity\Sygesca\Scout;
use App\Form\SearchMatriculeType;
use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $gestionRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


}
