<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/delete-user/{id}', name: 'delete_account')]
    public function deleteAccount($id, Request $request, EntityManagerInterface $entityManager): Response 
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if ($this->getUser() == $user) {
            $entityManager->remove($user);
            $entityManager->flush();
            $session = new Session();
            $session->invalidate();
            $this->addFlash('success', 'Votre compte a bien été supprimé.');
            return $this->redirectToRoute('main_home');
        } else {
            $this->addFlash('danger', 'L\'accès à cette page vous est interdit.');
            return $this->redirectToRoute('main_home');
        }
    }

    #[Route('/modifier-mot-de-passe', name: 'change_password')]
    public function modifyPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response 
    {
        $user = $this->getUser();
    
        $changePasswordForm = $this->createForm(ChangePasswordFormType::class, $user);
        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $changePasswordForm->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été modifié.');
            return $this->redirectToRoute('app_infos');
        }

        return $this->render('infos/change_password.html.twig', [
            'controller_name' => 'SecurityController',
            'changePasswordForm' => $changePasswordForm
        ]);

    }
}
