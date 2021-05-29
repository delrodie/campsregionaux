<?php

namespace App\Controller;

use App\Entity\Sygesca\Groupe;
use App\Entity\Sygesca\Scout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/inscription")
 */
class InscriptionController extends AbstractController
{
    /**
     * @Route("/", name="app_inscription", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {

        $em = $this->getDoctrine()->getManager();

        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $slug = strtoupper($this->validForm($request->get('inscription_scout')));
        $groupeId = strtoupper($this->validForm($request->get('inscription_groupe')));

        $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy(['slug' => $slug]);

        if ($scout){
            // enregistrement dans la table paiement;
            // redirection vers la page de confirmation selon la region
        }

        dd($scout);

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    /**
     * fonction verification des valeurs
     *
     * @param $donnee
     * @return string
     */
    public function validForm($donnee)
    {
        $result = htmlspecialchars(stripslashes(trim($donnee)));

        return $result;
    }
}
