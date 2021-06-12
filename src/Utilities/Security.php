<?php

namespace App\Utilities;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Security
{
    private $entityManager;
    private $passwordEncoder;
    private $security;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, \Symfony\Component\Security\Core\Security $security, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    /**
     * Initialisation des utilisateurs par la creation du compte du super admin
     *
     * @return bool
     */
    public function initalisationUser()
    {
        $user = new User();
        $user->setUsername('delrodie');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'sicre2021'));
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setEmail('delrodieamoikon@gmail.com');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }

    public function connexion()
    {
        //$user = $this->security->getUser();
        $user = $this->userRepository->findOneBy(['username'=>$this->security->getUser()->getUsername()]); //dd($user);

        $nombre_connexion = $user->getConnexion();
        //$date = new \DateTime();
        $user->setConnexion($nombre_connexion+1);
        $user->setLastconnectedAt(new \DateTime());

        $this->entityManager->flush();

        return true;
    }
}