<?php

namespace App\Controller;

use App\Entity\Sygesca\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/ajax")
 */
class AjaxController extends AbstractController
{
    /**
     * @Route("/", name="requete_ajax", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        //$field = $request->get('field');
        $value = $request->get('value');

        $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findBy(['district'=>$value],['paroisse'=>"ASC"]);

        $data = $this->json($groupes);

        return $data;
    }
}
