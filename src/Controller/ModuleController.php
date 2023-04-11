<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Category;
use App\Form\ModuleType;
use App\Entity\Formation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }

    #[Route('/session/{id}/category/module/add', name: 'add_category_module')]
    public function add(ManagerRegistry $doctrine,Session $session, Request $request): Response
    {
        // dd($session);
         //  instanciation  
        $module = new Module();
        // creation d'un formulaire baser sur le $builder dans la class categoryType
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
        // isValid () remplace les filter input 
        if ($form->isSubmitted() && $form->isValid()) {
            // recuperer les données
            $module = $form->getData();
            // on recupere le managere doctrine
            $entityManager = $doctrine->getManager();
            //prepare en pdo , on prepare a l'execution l'objet module 
            $entityManager->persist($module);
            // execute,inserer dans la bdd
            $entityManager->flush();
            // retourner a la page qui affiche la session pour ajouter les modules
            return $this->redirectToRoute('show_session', ['id' => $session->getId()]);

        }
        return $this->render('module/add.html.twig', [
            'formAddModule' => $form->createView(),
        ]);
    }
}
