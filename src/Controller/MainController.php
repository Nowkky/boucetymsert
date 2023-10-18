<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function index(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response
    {
        $listeClients = $entityManager->getRepository(Clients::class)->findAll();

        $client = new Clients();

        $formClients = $this->createForm(ClientsType::class, $client);
        $formClients->handleRequest($request);

        $logoEntreprise = $formClients->get('image')->getData();

        if ($formClients->isSubmitted() && $formClients->isValid()) {
            if($logoEntreprise) {
                $nomImageOrigine = pathinfo($logoEntreprise->getClientOriginalName(), PATHINFO_FILENAME);
                $nomSafeImage = $slugger->slug($nomImageOrigine);
                $nouveauNomImage = $nomSafeImage . '-' . uniqid() . '.' . $logoEntreprise->guessExtension();

                try {
                    $logoEntreprise->move(
                        $this->getParameter('logoEntreprise'),
                        $nouveauNomImage
                    );
                } catch (FileException $e) {
                    throw new FileException('Echec de l\'upload de l\'image ! - ' + $e->getMessage());
                }

                $client->setImage($nouveauNomImage);

            }
            
            $entityManager->persist($client);
            $entityManager->flush(); 

            $this->addFlash('success', 'Client ajouté a la frise.');
            return $this->redirect($request->getUri());
        }


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'listeClients' => $listeClients,
            'formClients' => $formClients,
        ]);
    }

    #[Route('/a-propos', name: 'app_about')]
    public function prestations(): Response
    {
        return $this->render('main/about.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


}
