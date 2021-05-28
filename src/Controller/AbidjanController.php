<?php

namespace App\Controller;

use App\Utilities\GestionRegion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/", name="abidjan_index")
     */
    public function index(): Response
    {
        $region = $this->gestionRegion->getRegion(self::region);

        return $this->render('abidjan/index.html.twig', [
            'region' => $region,
        ]);
    }
}
