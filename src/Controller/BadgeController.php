<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\Sygesca\Region;
use App\Entity\Sygesca\Scout;
use App\Form\SearchCivilType;
use App\Form\SearchMatriculeType;
use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/badge")
 */
class BadgeController extends AbstractController
{
    private $gestionRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/{regionSlug}", name="app_badge_matricule", methods={"GET","POST"})
     */
    public function index(Request $request, $regionSlug): Response
    {
        $search = new Scout();
        $form = $this->createForm(SearchMatriculeType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $matricule = $search->getMatricule();
            $scout = $this->gestionRegion->badge($matricule, $regionSlug);

            if ($scout){
                return $this->render('home/badge.html.twig',[
                    'scout' => $scout,
                ]);
            }else{
                return $this->render('home/badge_404.html.twig');
            }
        }

        $region = $this->getDoctrine()->getRepository(Region::class)->findOneBy(['slug' => $regionSlug]);

        return $this->render($this->gestionRegion->renderBadge($region->getNom()), [
            'search' => $search,
            'civil' => false,
            'form' => $form->createView(),
            'region' => $region,
            'config' => $this->gestionRegion->getConfig($region->getId()),
        ]);
    }

    /**
     * @Route("/{regionSlug}/civil", name="app_badge_civil", methods={"GET","POST"})
     */
    public function civil(Request $request, $regionSlug)
    {
        $search = new Scout();
        $form = $this->createForm(SearchCivilType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // Recuperation des informations et de leur recherche dans la table scout
            $nom = $search->getNom();
            $prenom = $search->getPrenoms();
            $dateNaiss = $search->getDatenaiss();
            $lieuNaiss = $search->getLieunaiss();

            $scoutSearch = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy([
                'nom' => $nom,
                'prenoms' => $prenom,
                'datenaiss' => $dateNaiss,
                'lieunaiss' => $lieuNaiss,
                'cotisation' => '2020-2021'
            ]);

            // Si le scout existe alors renvoyer a abidjan_inscription
            $scout = $this->gestionRegion->badge($scoutSearch->getMatricule());

            if ($scout){
                return $this->render('home/badge.html.twig',[
                    'scout' => $scout,
                ]);
            }else{
                return $this->render('home/badge_404.html.twig');
            }

        }

        $region = $this->getDoctrine()->getRepository(Region::class)->findOneBy(['slug' => $regionSlug]);

        return $this->render($this->gestionRegion->renderBadge($region->getNom()), [
            'search' => $search,
            'civil' => true,
            'form' => $form->createView(),
            'region' => $region,
            'config' => $this->gestionRegion->getConfig($region->getId()),
        ]);
    }
}
