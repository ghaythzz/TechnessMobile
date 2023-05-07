<?php

namespace App\Repository;

use App\Entity\Panierx;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panierx>
 *
 * @method Panierx|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panierx|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panierx[]    findAll()
 * @method Panierx[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panierx::class);
    }

    public function save(Panierx $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Panierx $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        
    }
   

    public function delete(Panierx $panierx)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($panierx);
        $entityManager->flush();
    }
    

//    /**
//     * @return Panierx[] Returns an array of Panierx objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Panierx
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
