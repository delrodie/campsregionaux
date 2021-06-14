<?php

namespace App\Controller;

use App\Entity\Config;
use App\Utilities\GestionRegion;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/paiement")
 */
class BackendPaiementController extends AbstractController
{
    private $session;
    private $utility;
    private $gestionRegion;

    public function __construct(SessionInterface $session, Utility $utility, GestionRegion $gestionRegion)
    {
        $this->session = $session;
        $this->utility = $utility;
        $this->gestionRegion = $gestionRegion;
    }

    /**
     * @Route("/{statut}", name="backend_paiement_index")
     */
    public function index($statut): Response
    {
        if ($statut === 'VALID') $statutLibelle = 'valides';
        else $statutLibelle = 'non valides';

        return $this->render('backend_paiement/index.html.twig', [
            'listes' => $this->utility->listPaiement($statut),
            'statut' => $statutLibelle
        ]);
    }

    /**
     * @Route("/{idTransaction}/{regionId}-{region}", name="backend_paiement_show", methods={"GET"})
     */
    public function resolve($idTransaction, $regionId)
    {
        $config = $this->getDoctrine()->getRepository(Config::class)->findOneBy(['region'=>$regionId]);

        if ($config){
            return $this->redirect('http://sicre.scoutascci.org/cinetpay/notify/'.$config->getSiteId().'?cpm_trans_id='.$idTransaction);
        }

        return $this->redirectToRoute('backend_paiement_index',['statut'=>'UNKNOW']);
    }

}
