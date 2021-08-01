<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\CorrectionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/correction")
 */
class CorrectionController extends AbstractController
{
    /**
     * @Route("/", name="admin_correction")
     */
    public function index(): Response
    {
        return $this->render('correction/index.html.twig', [
            'controller_name' => 'CorrectionController',
        ]);
    }

    /**
     * @Route("/{slug}", name="admin_correction_scout")
     */
    public function affection(Request $request, Paiement $paiement)
    {
        $form = $this->createForm(CorrectionFormType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_paiement_show',[
                'idTransaction' => $paiement->getIdTransaction(),
                'region' => $paiement->getGroupe()->getDistrict()->getRegion()->getNom(),
                'regionId' => $paiement->getGroupe()->getDistrict()->getRegion()->getId()
            ]);
        }

        return $this->render('correction/affectation.html.twig',[
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }
}
