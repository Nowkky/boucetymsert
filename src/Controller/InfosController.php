<?php

namespace App\Controller;

use App\Form\ChangeInfosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfosController extends AbstractController
{
    #[Route('/mes-informations', name: 'app_infos')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeInfosType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                
                
                return $this->redirect($request->getUri());
            }

        return $this->render('infos/infos.html.twig', [
            'controller_name' => 'InfosController',
            'formInfos' => $form
        ]);
    }

    //fonction pour suppr compte
    //fonction pour modifier infos?
}
