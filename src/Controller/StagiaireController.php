<?php

namespace App\Controller;


use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    // #[Route('/stagiaire', name: 'app_stagiaire')]
    // public function index(): Response
    // {
    //     return $this->render('stagiaire/index.html.twig', [
    //         'controller_name' => 'StagiaireController',
    //     ]);
    // }

    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(ManagerRegistry $doctrine): Response
    {                                                             
        // findBy([],["titre","DESC"])       
        // findAll();
        $stagiaires = $doctrine->getRepository(Stagiaire::class)->findBy([],["nom"=>"ASC"]);      
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires
        ]);
    }



    #[Route('/stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire): Response
    {                                                                    
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }


}
