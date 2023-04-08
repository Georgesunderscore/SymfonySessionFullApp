<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Entity\ModulesDetails;

// -use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\SessionRepository;
// -use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Doctrine\ORM\EntityManagerInterface;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
    
    #[Route('/session/removeModule/{idSe}/{idMd}', name: 'module_session_remove')]
    public function removeModuleSession(EntityManagerInterface $em  ,$idSe ,$idMd):Response{         
        //get modulesdetail before
        $session = $em->getRepository(Session::class)->find($idSe);
        $moduleDetail = $em->getRepository(ModulesDetails::class)->find($idMd);
        
        $session->removeModulesDetail($moduleDetail);
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
    
    #[Route('/add/module/session/{idSe}/{idMd}', name: 'module_session_add')]
    public function addModuleSession(Request $request,EntityManagerInterface $entityManager,$idSe,$idMd){
        $session = $entityManager->getRepository(Session::class)->find($idSe);
        $module = $entityManager->getRepository(Module::class)->find($idMd);
        $moduleDetail = new ModulesDetails();
        $moduleDetail->setSession($session);
        $moduleDetail->setModule($module);
        $nbrjrs = $request->attributes->get('nbrjrs');   
        print( $nbrjrs);

        $moduleDetail->setNbrjours($nbrjrs);
        $session->addModulesDetail($moduleDetail);
        $entityManager->persist($moduleDetail);
        $entityManager->persist($session);

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
        $modulesNI = $sessionRepository->findModulesNonInclus($session->getId());
        return $this->render('session/show.html.twig', ['session' => $session,
                                                        'stagiairesNI' => $stagiairesNI,
                                                        'modulesNI' => $modulesNI
        ]);
        // return $this->redirectToRoute('show_session',['id' => $session->getId() , 'stagiaires' => $stagiaires]);                                                
        // return $this->redirectToRoute('show_session',['id' => $session->getId()]);                                                


    }
    
    


}
