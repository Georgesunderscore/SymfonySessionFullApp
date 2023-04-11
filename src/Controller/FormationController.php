<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(ManagerRegistry $doctrine): Response
    {                                                             
        // findBy([],["titre","DESC"])       
        // findAll();
        $formations = $doctrine->getRepository(Formation::class)->findBy([],["titre"=>"ASC"]);      
        return $this->render('formation/index.html.twig', [
            'formations' => $formations
        ]);
    }



    #[Route('/formation/add', name: 'add_formation')]
    // #[Route('/formation/{id}/edit', name: 'edit_formation')]

    public function add(ManagerRegistry $doctrine, Formation $formation = null, Request $request): Response
    {
        //  instanciation  
        if (!$formation) {
            $formation = new Formation();
        }
        // creation d'un formulaire baser sur le $builder dans la class formationType
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        // isValid () remplace les filter input 
        if ($form->isSubmitted() && $form->isValid()) {
            // recuperer les données
            $formation = $form->getData();
            // on recupere le managere doctrine
            $entityManager = $doctrine->getManager();
            //prepare en pdo , on prepare a l'execution l'objet entreprise 
            $entityManager->persist($formation);
            // execute,inserer dans la bdd
            $entityManager->flush();
            // retourner a la page qui affiche toutes les formation
            return $this->redirectToRoute('app_formation');
        }
        return $this->render('formation/add.html.twig', [
            'formAddFormation' => $form->createView(),
        ]);
    }


    #[Route('/formation/{id}', name: 'show_formation')]
    public function show(Formation $formation): Response
    {                                                                    
        return $this->render('formation/show.html.twig', [
            'formation' => $formation
        ]);
    }


}
