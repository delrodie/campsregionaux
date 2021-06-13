<?php

namespace App\Controller;

use App\Entity\Gestionnaire;
use App\Form\GestionnaireType;
use App\Repository\GestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestionnaire")
 */
class AdminGestionnaireController extends AbstractController
{
    /**
     * @Route("/", name="admin_gestionnaire_index", methods={"GET","POST"})
     */
    public function index(Request $request, GestionnaireRepository $gestionnaireRepository): Response
    {
        $gestionnaire = new Gestionnaire();
        $form = $this->createForm(GestionnaireType::class, $gestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gestionnaire);
            $entityManager->flush();

            $this->addFlash('success', $gestionnaire->getRegion()->getNom().' a bien été associé au compte '.$gestionnaire->getUser()->getUsername());

            return $this->redirectToRoute('admin_gestionnaire_index');
        }

        return $this->render('admin_gestionnaire/index.html.twig', [
            'listes' => $this->getList(),
            'gestionnaire' => $gestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="admin_gestionnaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gestionnaire = new Gestionnaire();
        $form = $this->createForm(GestionnaireType::class, $gestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gestionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gestionnaire_index');
        }

        return $this->render('admin_gestionnaire/new.html.twig', [
            'gestionnaire' => $gestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestionnaire_show", methods={"GET"})
     */
    public function show(Gestionnaire $gestionnaire): Response
    {
        return $this->render('admin_gestionnaire/show.html.twig', [
            'gestionnaire' => $gestionnaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_gestionnaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Gestionnaire $gestionnaire): Response
    {
        $form = $this->createForm(GestionnaireType::class, $gestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $gestionnaire->getRegion()->getNom().' a bien été associé au compte '.$gestionnaire->getUser()->getUsername());


            return $this->redirectToRoute('admin_gestionnaire_index');
        }

        return $this->render('admin_gestionnaire/edit.html.twig', [
            'gestionnaire' => $gestionnaire,
            'form' => $form->createView(),
            'listes' => $this->getList()
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gestionnaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Gestionnaire $gestionnaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gestionnaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gestionnaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_gestionnaire_index');
    }

    public function getList()
    {
        $gestionnaires = $this->getDoctrine()->getRepository(Gestionnaire::class)->findList();

        $listes=[]; $i=0;
        foreach($gestionnaires as $gestionnaire){
            $listes[$i++] = [
                'region' => $gestionnaire->getRegion()->getNom(),
                'user' => $gestionnaire->getUser()->getUsername(),
                'nom' => $gestionnaire->getNom(),
                'prenom' => $gestionnaire->getPrenom(),
                'tel' => $gestionnaire->getTel(),
                'id' => $gestionnaire->getId(),
            ];
        }

        return $listes;
    }
}
