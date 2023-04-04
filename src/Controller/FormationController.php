<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Formation;


class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(ManagerRegistry $doctrine): Response
    {                                                             
        // findBy([],["titre","DESC"])       
        $formations = $doctrine->getRepository(Formation::class)->findAll();
        return $this->render('formation/index.html.twig', [
            'formations' => $formations
        ]);
    }

    #[Route('/formation/{id}', name: 'show_formation')]
    public function show(): Response
    {                                                                    
        if($formation == null){
            $formation = new Formation();
        } 
        return $this->render('formation/show.html.twig', [
            'formation' => $formation
        ]);
    }


}
