<?php

namespace App\Controller;

use App\Entity\Sygesca\Scout;
use App\Form\SearchMatriculeType;
use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jambognan")
 */
class AbidjanController extends AbstractController
{
    const region = "ABIDJAN";

    private $gestionRegion;    private $getRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/", name="abidjan_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        // Recuperation de la region
        $region = $this->gestionRegion->getRegion(self::region);

        if (!$region){
            $this->addFlash('danger', "Votre lien n'est pas fonctionnel. Veuillez contacter l'équipe nationale");
            //Return 404
        }else{
            return $this->redirectToRoute('app_search_matricule',['region' => $region->getSlug()]);
        }



        return $this->render('abidjan/index.html.twig', [
            'region' => $region,
        ]);
    }
}
