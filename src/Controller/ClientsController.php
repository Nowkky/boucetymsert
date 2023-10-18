<?php

namespace App\Controller;

use App\Entity\Clients;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends AbstractController
{

    #[Route('/delete-client/{id}', name: 'app_delete_client')]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        if ($this->IsGranted("ROLE_ADMIN")) {
            $client = $entityManager->getRepository(Clients::class)->find($id);
            $entityManager->remove($client);
            $entityManager->flush();
            
            $this->addFlash('success', 'Client supprimé.');
            return $this->redirectToRoute('main_home');
        } else {
            $this->addFlash('danger', 'Une erreur s\'est produite.');
            return $this->redirectToRoute('main_home');
        }
    }
}
