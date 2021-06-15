<?php

namespace App\Controller;

use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/campbonou")
 */
class BouakeController extends AbstractController
{
    const region = "BOUAKE";

    private $gestionRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/", name="bouake_index", methods={"GET","POST"})
     */
    public function index(): Response
    {
        // Recuperation de la region
        $region = $this->gestionRegion->getRegion(self::region);

        if (!$region){
            $this->addFlash('danger', "Votre lien n'est pas fonctionnel. Veuillez contacter l'équipe nationale");
            //Return 404
        }else{
            return $this->redirectToRoute('app_search_matricule',['region' => $region->getSlug()]);
        }

        return $this->render('bouake/index.html.twig', [
            'controller_name' => 'BouakeController',
        ]);
    }
}
