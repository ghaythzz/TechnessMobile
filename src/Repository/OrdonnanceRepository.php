<?php

namespace App\Repository;

use App\Entity\Ordonnance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ordonnance>
 *
 * @method Ordonnance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordonnance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordonnance[]    findAll()
 * @method Ordonnance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdonnanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordonnance::class);
    }

    public function save(Ordonnance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ordonnance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getOrdonnaceByFiche(int $ficheId)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.reservations','r')
            ->innerJoin('r.Fiche','f')
            ->where('f.id = :id')
            ->setParameter('id', $ficheId)
            ->getQuery()
            ->getResult();
    }
    public function search(?string $nom, ?string $date, string $commentaire, int $doctorId): array
    {
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.patient','p')
            ->innerJoin('o.doctor','d')
            ->where('o.commentaire LIKE :commentaire')
            ->setParameter('commentaire','%'.$commentaire.'%')
            ->andWhere('d.id = :id')
            ->setParameter('id',$doctorId);

        if ($nom) {
            $qb->andWhere('p.nom LIKE :nom')
                ->setParameter('nom','%'.$nom.'%');
        }

        if ($date) {
            $qb->andWhere('o.date = :date')
                ->setParameter('date',$date);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Ordonnance[] Returns an array of Ordonnance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ordonnance
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
