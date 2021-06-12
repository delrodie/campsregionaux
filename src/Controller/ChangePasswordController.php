<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/change-password")
 */
class ChangePasswordController extends AbstractController
{
    /**
     * @Route("/", name="app_change_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, SessionInterface $session): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        # tetste

        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();

            $request_token = $request->get('_token');
            $session_token = $session->get('updatePassword');

            if ($request_token !== $session_token){
                $this->addFlash('danger', "Veuillez vous reconnecter pour modifier votre mot de passe");
                return $this->redirectToRoute('app_logout');
            }

            $encodePassword = $userPasswordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodePassword);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Mot de passe changé avec succès");

            return $this->redirectToRoute('app_logout');
        }
        return $this->render('change_password/index.html.twig', [
            'resetForm' => $form->createView(),
            'token' => $session->get('updatePassword')
        ]);
    }
}
