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
                $conversation->setLastMessageDate(new \DateTimeImmutable());

                $entityManager->persist($conversation);
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
            $user = $this->getUser();
            $listConversation = $entityManager->getRepository(Conversation::class)->findAllConversationsByLastMessageDateDesc();

            $selectedConversation = null;
            $messagesList = null;

            $conversationId = $request->query->get('conversation_id');

            if ($conversationId) {
                $selectedConversation = $entityManager->getRepository(Conversation::class)->find($conversationId);
                $messagesList = $selectedConversation->getMessages();
            }


            $message = new Messages();
            $form = $this->createForm(MessagesType::class, $message);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $message->setAuthor($user);
                $message->setConversation($selectedConversation);
                $selectedConversation->setLastMessageDate(new \DateTimeImmutable());

                $entityManager->persist($selectedConversation);
                $entityManager->persist($message);
                $entityManager->flush();
                return $this->redirect($request->getUri());
            }

            

            return $this->render('messages/admin.html.twig', [
                'controller_name' => 'MessagesController',
                'listConversation' => $listConversation,
                'selectedConversation' => $selectedConversation,
                'messagesList' => $messagesList,
                "formMessage" => $form->createView()
            ]);
        } else {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page. Veuillez vous authentifier ou vous inscrire.');
            return $this->redirectToRoute('main_home');
        }
    }
}
