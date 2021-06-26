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
        if ($statut === 'VALID') $statutLibelle = 'validées';
        else $statutLibelle = 'non achevées';

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
            //$siteId = 859470; $id_transaction = '20210610175018-60c250da8dbb3';
            //$siteId = $config->getSiteId(); $id_transaction = $idTransaction;
            //return $this->redirect('http://sicre.scoutascci.org/cinetpay/notify/859470?cpm_trans_id=20210610175018-60c250da8dbb3');
            //$old = 'http://sicre.scoutascci.org/cinetpay/notify/'.$config->getSiteId().'?cpm_trans_id='.$idTransaction; dd($old);
            //$url = "http://sicre.scoutascci.org/cinetpay/notify/859470?cpm_trans_id=20210610175018-60c250da8dbb3";
            //$url = "http://sicre.scoutascci.org/cinetpay/notify/".$siteId."?cpm_trans_id=".$id_transaction;

            $url = sprintf('http://sicre.scoutascci.org/cinetpay/notify/%d?cpm_trans_id=%s', $config->getSiteId(), $idTransaction);
            //die($url);

            return $this->redirect($url);
        }

        return $this->redirectToRoute('backend_paiement_index',['statut'=>'UNKNOW']);
    }

}
