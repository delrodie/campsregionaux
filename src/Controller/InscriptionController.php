<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Paiement;
use App\Entity\Participant;
use App\Entity\Sygesca\Groupe;
use App\Entity\Sygesca\Region;
use App\Entity\Sygesca\Scout;
use App\Entity\Sygesca\Statut;
use App\Utilities\GestionRegion;
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
    private $gestionRegion;

    public function __construct(GestionRegion $gestionRegion)
    {
        $this->gestionRegion = $gestionRegion;
    }

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
        $regionsSlug = strtoupper($this->validForm($request->get('inscription_region')));
        $activiteId = strtoupper($this->validForm($request->get('inscription_activite')));

        $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy(['slug' => $slug]);

        if ($scout){
            // Recherche des entittés
            $groupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy(['id'=>$groupeId]);
            $region = $this->getDoctrine()->getRepository(Region::class)->findOneBy(['slug'=>$regionsSlug]); //dd($region);
            $activite = $this->getDoctrine()->getRepository(Activite::class)->findOneBy(['id'=>$activiteId]);
            $statut = $this->getDoctrine()->getRepository(Statut::class)->findOneBy(['id'=>$scout->getStatut()]);
            $montant = $this->gestionRegion->montantParticipation($region->getId());

            // Verification de l'existence du scout dans la table paiement
            $verifPaiement = $this->getDoctrine()->getRepository(Paiement::class)->findOneBy([
                'carte' => $scout->getCarte(),
                'matricule' => $scout->getMatricule()
            ]);

            // Verification de l'existence du scout dans la table participant

            $id_transaction = date('YmdHis').'-'.uniqid();
            $status_paiement = 'UNKNOW';

            if ($verifPaiement){
                // Verification si la transaction precedente a abouti sinon faire une mise a jour
                if ($verifPaiement->getStatusPaiement() !== 'VALID' && $verifPaiement->getStatut() !== '00'){
                    $verifPaiement->setMontant($montant);
                    $verifPaiement->setActivite($activite);
                    $verifPaiement->setGroupe($groupe);

                    $em->flush();

                    $message = [
                        'id' => $id_transaction,
                        'status' => true,
                        'amount' => $montant,
                        'slug' => $verifPaiement->getSlug()
                    ];

                    return $this->json($message);

                }else{
                    $message = [
                        'msg' => "Vous êtes déjà inscrit(e)",
                        'status' => false
                    ];
                }

                return $this->json($message);
            }else{

                // enregistrement dans la table paiement;
                $paiement = new Paiement();

                $paiement->setIdTransaction($id_transaction);
                $paiement->setStatusPaiement($status_paiement);
                $paiement->setNom($scout->getNom());
                $paiement->setPrenoms($scout->getPrenoms());
                $paiement->setSexe($scout->getSexe());
                $paiement->setDateNaissance($scout->getDatenaiss());
                $paiement->setLieuNaissance($scout->getLieunaiss());
                $paiement->setCarte($scout->getCarte());
                $paiement->setMatricule($scout->getMatricule());
                $paiement->setFonction($scout->getFonction());
                $paiement->setContact($scout->getContact());
                $paiement->setUrgence($scout->getUrgence());
                $paiement->setContactUrgence($scout->getContactparent());
                $paiement->setSlug($scout->getSlug());
                $paiement->setMontant($montant);
                $paiement->setActivite($activite);
                $paiement->setGroupe($groupe);
                $paiement->setType($statut);

                $em->persist($paiement);
                $em->flush();

                $message = [
                    'id' => $id_transaction,
                    'status' => true,
                    'amount' => $montant,
                    'slug' => $paiement->getSlug()
                ];

                return $this->json($message);
            }

            // redirection vers la page de confirmation selon la region
        }



        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    /**
     * @Route("/{idTransaction}", name="app_inscription_badge", methods={"GET","POST"})
     */
    public function badge($idTransaction)
    {
        $paiement = $this->getDoctrine()->getRepository(Paiement::class)->findOneBy(['idTransaction' => $idTransaction]);
        dd($paiement);
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
