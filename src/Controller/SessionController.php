<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// -use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
// -use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpKernel\Attribute\Cache;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

    #[Route('/session/removeStagiaire/{idSe}/{idSt}', name: 'stagiaire_inscription_remove')]
    public function removeStagiaireInscription(Request $request,
                                                #[MapEntity(mapping: ['idSe' => 'id'])]
                                                Session $session,
                                                #[MapEntity(mapping: ['idSt' => 'id'])]
                                                Stagiaire $stagiaire,ManagerRegistry $doctrine ){         
        // $doctrine = $this->getEntityManager();
        $em = $doctrine->getManager();
        $session->removeStagiaire($stagiaire);
        $em->persist($session);
        $em->flush();
        $this->redirectToRoute('show_session',['id' => $session->getId()]);                                                

        // return $this->render('session/show.html.twig', ['Deleted'=>'True']);
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
    public function show(Session $session): Response
    {                                                                    
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }
    
    


}
