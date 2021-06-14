<?php

namespace App\Controller;

use App\Entity\Config;
use App\Form\ConfigType;
use App\Repository\ConfigRepository;
use App\Utilities\GestionMedia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/config")
 */
class BackendConfigController extends AbstractController
{
    private $gestionMedia;

    public function __construct(GestionMedia $gestionMedia)
    {
        $this->gestionMedia = $gestionMedia;
    }

    /**
     * @Route("/", name="backend_config_index", methods={"GET","POST"})
     */
    public function index(Request $request, ConfigRepository $configRepository): Response
    {
        $config = new Config();
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();


            $mediaFile = $form->get('logoRegion')->getData(); //dd($mediaFile);
            $mediaBg = $form->get('bg')->getData(); //dd($mediaFile);

            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'configLogo');

                $config->setLogoRegion($media);
            }

            if ($mediaBg){
                $mediaB = $this->gestionMedia->upload($mediaBg, 'configBg');

                $config->setBg($mediaB);
            }

            $entityManager->persist($config);
            $entityManager->flush();

            return $this->redirectToRoute('backend_config_index');
        }

        return $this->render('backend_config/index.html.twig', [
            'configs' => $configRepository->findAll(),
            'config' => $config,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_config_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $config = new Config();
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($config);
            $entityManager->flush();

            return $this->redirectToRoute('backend_config_index');
        }

        return $this->render('backend_config/new.html.twig', [
            'config' => $config,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_config_show", methods={"GET"})
     */
    public function show(Config $config): Response
    {
        return $this->render('backend_config/show.html.twig', [
            'config' => $config,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_config_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Config $config, ConfigRepository $configRepository): Response
    {
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $mediaFile = $form->get('logoRegion')->getData(); //dd($mediaFile);
            $mediaBg = $form->get('bg')->getData(); //dd($mediaFile);

            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'configLogo');

                $config->setLogoRegion($media);
            }

            if ($mediaBg){
                $mediaB = $this->gestionMedia->upload($mediaBg, 'configBg');

                $config->setBg($mediaB);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_config_index');
        }

        return $this->render('backend_config/edit.html.twig', [
            'configs' => $configRepository->findAll(),
            'config' => $config,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_config_delete", methods={"POST"})
     */
    public function delete(Request $request, Config $config): Response
    {
        if ($this->isCsrfTokenValid('delete'.$config->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($config);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_config_index');
    }
}
