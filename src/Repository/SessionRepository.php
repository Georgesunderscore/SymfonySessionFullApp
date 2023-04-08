<?php

namespace App\Repository;

use App\Entity\Module;
use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function save(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// list des stagiares non inscrits
public function findNonInscrits($session_id){
    $em = $this->getEntityManager();
    
    $qb = $em->createQueryBuilder();
    // séléctionner tous les stagiaires d'une session dont l'id est passé en paramètre
    $qb->select('s')
        // ->from(Stagiaire::class,'s')
        ->from('App\Entity\Stagiaire','s')
        ->leftJoin('s.sessions', 'se')
        ->where('se.id = :id');
        // ->setParameter('id', $session_id)
        // ->andWhere('s.status = :status')
        // ->setParameter('status', Session::STATUS_INACTIVE)
        // ->getQuery()
        // ->getResult();
    $sub = $em->createQueryBuilder();
    // sélectionner tous les stagiaires qui ne sont pas (NOT IN ) dans le résultat précédent
    // on obtient les stagiaires non inscrits pour une session définie
    $sub->select('st')
        ->from('App\Entity\Stagiaire','st')
        ->where($sub->expr()->notIn('st.id',$qb->getDQL()))
        // requete parametrée
        ->setParameter('id', $session_id)
        // trier la liste des stagiaires par le nom de famille 
        ->orderBy('st.nom', 'ASC');
        // renvoyer le resultat
    $query = $sub->getQuery();
    return $query->getResult();
    // return $qb->getQuery()->getResult();
    }
    
    // list des Modules non inclus
    public function findModulesNonInclus($session_id){
        $em = $this->getEntityManager();
        
        $qb = $em->createQueryBuilder();
        // séléctionner tous les stagiaires d'une session dont l'id est passé en paramètre
        $qb->select('m')
            // ->from(Module::class,'m')
            ->from('App\Entity\Module','m')
            ->leftJoin('m.modulesDetails', 'mds')
            ->where('mds.session = :id');
        $sub = $em->createQueryBuilder();
        // sélectionner tous les modules qui ne sont pas (NOT IN ) dans le résultat précédent
        // on obtient les modules non inv=clus pour une session définie
        $sub->select('md')
            ->from('App\Entity\Module','md')
            ->where($sub->expr()->notIn('md.id',$qb->getDQL()))
            // requete parametrée
            ->setParameter('id', $session_id);
            // trier la liste des stagiaires par le nom de famille 
            // ->orderBy('md.nom', 'ASC');
            // renvoyer le resultat
        $query = $sub->getQuery();
        return $query->getResult();
        // return $qb->getQuery()->getResult();
        }

}
