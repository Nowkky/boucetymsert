<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Messages;
use App\Entity\User;
use App\Form\MessagesType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MessagesController extends AbstractController
{
    
    #[Route('/messagerie', name: 'app_messages')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->IsGranted("ROLE_USER")) {
            $user = $this->getUser();
            $repoUser = $entityManager->getRepository(User::class);
            $repoMessages = $entityManager->getRepository(Messages::class);
            $repoConversation = $entityManager->getRepository(Conversation::class);

            //Vérification si une conversation existe avec cet utilisateur, si non, la créé
            if ($user->getConversation() != null) {
                $conversation = $user->getConversation();
            } else {
                $conversation = new Conversation();
                $conversation->setUser($user);
                $entityManager->persist($conversation);
                $entityManager->flush();
            }

            $message = new Messages();
            $form = $this->createForm(MessagesType::class, $message);
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                
                $message->setAuthor($user);
                $message->setConversation($conversation);
                
                $entityManager->persist($message);
                $entityManager->flush();
                return $this->redirect($request->getUri());
            }
            
            $messagesList = $conversation->getMessages();

                return $this->render('messages/index.html.twig', [
                    'controller_name' => 'MessagesController',
                    'messagesList' => $messagesList,
                    "formMessage" => $form->createView()
                ]);
        } else {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page. Veuillez vous authentifier ou vous inscrire.');
            return $this->redirectToRoute('main_home');
        }

    }

    #[Route('/messagerie-admin', name: 'admin_messages')]
    public function admin(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->IsGranted("ROLE_ADMIN")) {         
                $listConversation = $entityManager->getRepository(Conversation::class)->findAll();
    

                // $repoUser= $entityManager->getRepository(User::class);
                // $adminReceiver = $repoUser->find(1);
                // $repoMessages = $entityManager->getRepository(Messages::class);
                // $messagesList = $repoMessages->findMessagesFromUsers($this->getUser(), $adminReceiver);
                
                // $message = new Messages();
                // $form = $this->createForm(MessagesType::class, $message);
        
                // $form->handleRequest($request);
        
                // if ($form->isSubmitted() && $form->isValid()) {
                //     //l'auteur du message est l'utilisateur courant
                //     $message->setAuthor($this->getUser());
                //     //le receveur est forcément l'administrateur, qui détient l'id 1 dans la bdd
                //     $message->setReceiver($adminReceiver);

                //     $entityManager->persist($message);
                //     $entityManager->flush();
                // }

                return $this->render('messages/admin.html.twig', [
                    'controller_name' => 'MessagesController',
                    'listConversation' => $listConversation
                ]);
        } else {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page. Veuillez vous authentifier ou vous inscrire.');
            return $this->redirectToRoute('main_home');
        }

    }

}
