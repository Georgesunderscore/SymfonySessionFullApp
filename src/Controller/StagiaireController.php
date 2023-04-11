<?php

namespace App\Controller;


use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/stagiaire/add', name: 'add_stagiaire')]
    // #[Route('/stagiaire/{id}/edit', name: 'edit_stagiaire')]

    public function add(ManagerRegistry $doctrine, Stagiaire $stagiaire = null, Request $request): Response
    {
        //  instanciation  
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }
        // creation d'un formulaire baser sur le $builder dans la class stagiaireType
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);
        // isValid () remplace les filter input 
        if ($form->isSubmitted() && $form->isValid()) {
            // recuperer les données
            $stagiaire = $form->getData();
            // on recupere le managere doctrine
            $entityManager = $doctrine->getManager();
            //prepare en pdo , on prepare a l'execution l'objet entreprise 
            $entityManager->persist($stagiaire);
            // execute,inserer dans la bdd
            $entityManager->flush();
            // retourner a la page qui affiche toutes les stagiaire
            return $this->redirectToRoute('app_stagiaire');
        }
        return $this->render('stagiaire/add.html.twig', [
            'formAddStagiaire' => $form->createView(),
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
