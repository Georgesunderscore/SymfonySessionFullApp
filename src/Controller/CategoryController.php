<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/add', name: 'add_category')]
    // #[Route('/category/{id}/edit', name: 'edit_category')]

    public function add(ManagerRegistry $doctrine, Category $category = null, Request $request): Response
    {
        //  instanciation  
        if (!$category) {
            $category = new Category();
        }
        // creation d'un formulaire baser sur le $builder dans la class categoryType
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        // isValid () remplace les filter input 
        if ($form->isSubmitted() && $form->isValid()) {
            // recuperer les données
            $category = $form->getData();
            // on recupere le managere doctrine
            $entityManager = $doctrine->getManager();
            //prepare en pdo , on prepare a l'execution l'objet entreprise 
            $entityManager->persist($category);
            // execute,inserer dans la bdd
            $entityManager->flush();
            // retourner a la page qui affiche toutes les category
            return $this->redirectToRoute('app_category');
        }
        return $this->render('category/add.html.twig', [
            'formAddCategory' => $form->createView(),
        ]);
    }
}
