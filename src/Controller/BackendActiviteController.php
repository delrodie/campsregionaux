<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Utilities\GestionMedia;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/activite")
 */
class BackendActiviteController extends AbstractController
{
    private $gestionMedia;

    public function __construct(GestionMedia $gestionMedia)
    {
        $this->gestionMedia = $gestionMedia;
    }

    /**
     * @Route("/", name="backend_activite_index", methods={"GET","POST"})
     */
    public function index(Request $request, ActiviteRepository $activiteRepository): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Slug
            $slugify = new Slugify();
            $slug = $slugify->slugify($activite->getNom());


            $mediaFile = $form->get('logo')->getData(); //dd($mediaFile);

            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'activite'); //dd($activite->getLogo());

                // Supression de l'ancien fichier
                //$this->gestionMedia->removeUpload($activite->getLogo(), 'activite');

                $activite->setLogo($media);
            }

            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('backend_activite_index');
        }

        return $this->render('backend_activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_activite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Slug
            $slugify = new Slugify();
            $slug = $slugify->slugify($activite->getNom());
            //dd($slug);
            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('backend_activite_index');
        }

        return $this->render('backend_activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_activite_show", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {
        return $this->render('backend_activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_activite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Slug
            $slugify = new Slugify();
            $slug = $slugify->slugify($activite->getNom());


            $mediaFile = $form->get('logo')->getData(); //dd($mediaFile);

            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'activite'); //dd($activite->getLogo());

                // Supression de l'ancien fichier
                //$this->gestionMedia->removeUpload($activite->getLogo(), 'activite');

                $activite->setLogo($media);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_activite_index');
        }

        return $this->render('backend_activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_activite_delete", methods={"POST"})
     */
    public function delete(Request $request, Activite $activite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $media = $activite->getLogo();
            $entityManager->remove($activite);
            $entityManager->flush();

            // Supression de l'ancien fichier
            $this->gestionMedia->removeUpload($activite->getLogo(), 'activite');
        }

        return $this->redirectToRoute('backend_activite_index');
    }
}
