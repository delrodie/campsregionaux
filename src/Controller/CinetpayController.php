<?php


namespace App\Controller;


use App\Entity\Paiement;
use CinetPay\CinetPay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CinetpayController
 * @Route("/cinetpay")
 */
class CinetpayController extends AbstractController
{

    /**
     * @Route("/notify", name="cinetpay_notification", methods={"GET","POST"})
     */
    public function notify(Request $request): Response
    {
        //Initialisation
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();

        $cpmTransId = $request->get('cpm_trans_id');
         if (isset($cpmTransId)){
            try {
                // Initialisation de CinetPay et identification de paiement

                $id_transaction = $cpmTransId;
                $apiKey = '18714242495c8ba3f4cf6068.77597603';
                $site_id = 422630;
                $plateform = "PROD"; // Valorisé à PROD si vous êtes en production

                $CinetPay = new CinetPay($site_id, $apiKey, $plateform);

                // Reprise exacte des bonnes données chez CinetPay
                $CinetPay->setTransId($id_transaction)->getPayStatus();
                $cpm_site_id = $CinetPay->_cpm_site_id;
                $signature = $CinetPay->_signature;
                $cpm_amount = $CinetPay->_cpm_amount;
                $cpm_trans_id = $CinetPay->_cpm_trans_id;
                $cpm_custom = $CinetPay->_cpm_custom;
                $cpm_currency = $CinetPay->_cpm_currency;
                $cpm_payid = $CinetPay->_cpm_payid;
                $cpm_payment_date = $CinetPay->_cpm_payment_date;
                $cpm_payment_time = $CinetPay->_cpm_payment_time;
                $cpm_error_message = $CinetPay->_cpm_error_message;
                $payment_method = $CinetPay->_payment_method;
                $cpm_phone_prefixe = $CinetPay->_cpm_phone_prefixe;
                $cel_phone_num = $CinetPay->_cel_phone_num;
                $cpm_ipn_ack = $CinetPay->_cpm_ipn_ack;
                $created_at = $CinetPay->_created_at;
                $updated_at = $CinetPay->_updated_at;
                $cpm_result = $CinetPay->_cpm_result;
                $cpm_trans_status = $CinetPay->_cpm_trans_status;
                $cpm_designation = $CinetPay->_cpm_designation;
                $buyer_name = $CinetPay->_buyer_name;

                // Verification de l'effectivité de l'opération de CinetPay
                if ($cpm_result === '00'){

                    // Véification de la transaction dans la base données
                    // Si l'opération existe et que le statut est égal à 0 alors participant déja inscris
                    // Sinon enregistrer l'opération
                    $paiement = $this->getDoctrine()->getRepository(Paiement::class)->findOneBy(['idTransaction'=>$id_transaction]);
                    if ($paiement->getStatut() == '00'){
                        $message = [
                          'id'=>$id_transaction,
                            'phone' => $cel_phone_num,
                            'date'=> $cpm_payment_date,
                            'time' => $cpm_payment_time
                        ];

                        return $this->json($message);
                    }else{

                    }
                }
            } catch (Exception $e){
                echo "Erreur :" .$e->getMessage();
            }
         }else{
             return $this->redirectToRoute('app_search_matricule');
         }

    }
}