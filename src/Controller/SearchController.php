<?php


namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Sygesca\Region;
use App\Entity\Sygesca\Scout;
use App\Form\SearchMatriculeType;
use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    private $gestionRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
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
            'config' => $this->gestionRegion->getConfig($region->getId()),
            'activite' => $this->getDoctrine()->getRepository(Activite::class)->findOneBy(['region'=>$region->getId()])
        ]);
    }
}