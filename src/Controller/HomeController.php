<?php

namespace App\Controller;

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

    /**
     * @Route("/{region}", name="app_search_matricule", methods={"GET","POST"})
     */
    public function matricule(Request $request, Region $region)
    {
        // Formulaire de recherche
        $search = new Scout();
        $form = $this->createForm(SearchMatriculeType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // Recuperation du matricule puis de la recherche dans la table scout
            $matricule = $search->getMatricule();
            $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy(['matricule'=> $matricule]);

            // Si le scout existe alors renvoyer a abidjan_inscription
            if ($scout){
                return $this->redirectToRoute('app_search_result', [
                    'regionSlug' => $region->getSlug(),
                    'slug' => $scout->getSlug(),
                ]);
            }

            return $this->redirectToRoute('app_home');
            // Sinon afficher la page d'accueil

        }

        return $this->render($this->gestionRegion->renderSearch($region->getNom()),[
            'search' => $search,
            'region' => $region,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{regionSlug}/{slug}", name="app_search_result", methods={"GET","POST"})
     */
    public function inscription(Request $request, $regionSlug, $slug)
    {
        $region = $this->getDoctrine()->getRepository(Region::class)->findOneBy(['slug'=>$regionSlug]);
        $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy(['slug'=>$slug]);

        return $this->render($this->gestionRegion->renderInscription($region->getNom()),[
            'region' => $region,
            'scout' => $scout,
            'districts' => $this->getDoctrine()->getRepository(District::class)->findBy(['region'=>$region->getId()]),
        ]);
    }
}
