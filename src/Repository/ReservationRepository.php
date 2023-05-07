<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function ghayth($id): array
    {
       return $this->createQueryBuilder('s')
      
       ->where('s.patient = :idc') 
       ->setParameter('idc',$id)
       ->getQuery()
       ->getResult();
   
    }

    public function ghayth_med($id): array
    {
       return $this->createQueryBuilder('s')
      
       ->where('s.users = :idc') 
       ->setParameter('idc',$id)
       ->getQuery()
       ->getResult();
   
    }
    public function getReservationByFiche(int $ficheId)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.Fiche','f')
            ->where('f.id = :id')
            ->setParameter('id', $ficheId)
            ->orderBy('r.start', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function sort($id): array
    {
       return $this->createQueryBuilder('s')
       ->where('s.patient = :idc')
       ->setParameter('idc',$id)
       ->orderBy('s.start', 'ASC')
       ->getQuery()
       ->getResult();
   
    }


//    /**
//     * @return Reservation[] Returns an array of Reservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
