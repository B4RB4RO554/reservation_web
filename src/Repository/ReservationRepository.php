<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Terrain;
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

    public function findAll(): array
{
    return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC')
        ->getQuery()
        ->getResult();
}
    public function finduserbynom($type)
    {
        return $this->createQueryBuilder('Reservation')
            ->where('Reservation.type LIKE :type')
            ->setParameter('type', '%'.$type.'%')
            ->getQuery()
            ->getResult();
    }
    public function findExistingReservation(Terrain $terrain, \DateTimeInterface $date, String $heure): ?Reservation
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.terrain = :terrain')
        ->andWhere('r.date_r = :date')
        ->andWhere('r.heure_r = :heure')
        ->setParameter('terrain', $terrain)
        ->setParameter('date', $date)
        ->setParameter('heure', $heure)
        ->getQuery()
        ->getOneOrNullResult()
    ;
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
