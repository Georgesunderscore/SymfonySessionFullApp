<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;

// -use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
// -use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Request;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    
    // #[MapEntity(mapping: ['idSe' => 'id'])]
    // Session $session,
    // #[MapEntity(mapping: ['idSt' => 'id'])]
    // Stagiaire $stagiaire
    #[Route('/session/removeStagiaire/{idSe}/{idSt}', name: 'stagiaire_inscription_remove')]
    public function removeStagiaireInscription(EntityManagerInterface $em ,$idSe ,$idSt):Response{         
        $session = $em->getRepository(Session::class)->find($idSe);
        $stagiaire = $em->getRepository(Stagiaire::class)->find($idSt);
        $session->removeStagiaire($stagiaire);
        $stagiaire->removeSession($session);
        // $em = $doctrine->getManager();
        $em->persist($session);
        $em->flush();
        return $this->redirectToRoute('show_session',['id' => $session->getId()]);                                                
        // return $this->render('session/show.html.twig', ['session' => $session]);
    }
   
    #[Route('/add/stagiaire/session/{idSe}/{idSt}', name: 'stagiaire_session_add')]
    public function addStagiaireSession(EntityManagerInterface $entityManager,$idSe,$idSt): Response
    {
        $session = $entityManager->getRepository(Session::class)->find($idSe);
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($idSt);
        $session->addStagiaire($stagiaire);
        $stagiaire->addSession($session);


        // tell Doctrine you want to (eventually) save the Session (no queries yet)
        $entityManager->persist($session);
        $entityManager->persist($stagiaire);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // return $this->render('session/show.html.twig', ['session' => $session]);
        return $this->redirectToRoute('show_session',['id' => $session->getId()]);                                                


    }
    
    // #[Route('/session/removeStagiaire/{idSe}/{idSt}', name: 'stagiaire_inscription_remove')]
    // #[ParamConverter('session', options: ['mapping' => ['idSe' => 'id']])]
    // #[ParamConverter('stagiaire', options: ['mapping' => ['idSt' => 'id']])]
    // public function removeStagiaireInscription( ManagerRegistry $doctrine , Session $session,Stagiaire $stagiaire){         
        
    //     // $doctrine = $this->getEntityManager();
    //     $em = $doctrine->getManager();
    //     $session->removeStagiaire($stagiaire);
    //     $em->persist($session);
    //     $em->flush();
        
    //     $this->redirectToRoute('show_session',['id' => $session->getId()]);                                                
    //     // return $this->render('session/show.html.twig', ['Deleted'=>'True']);
    // }
    
    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session,SessionRepository $sessionRepository): Response
    {   
        // list des stagiaires
        // $stagiaires = $doctrine->getRepository(Stagiaire::class)->findBy([],["nom"=>"ASC"]);      
        $stagiairesNI = $sessionRepository->findNonInscrits($session->getId());

        return $this->render('session/show.html.twig', ['session' => $session,
                                                        'stagiairesNI' => $stagiairesNI
        ]);
        // return $this->redirectToRoute('show_session',['id' => $session->getId() , 'stagiaires' => $stagiaires]);                                                
        // return $this->redirectToRoute('show_session',['id' => $session->getId()]);                                                


    }
    
    


}
