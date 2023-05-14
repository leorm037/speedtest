<?php

namespace App\Repository;

use App\Entity\Speedtest;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Speedtest>
 *
 * @method Speedtest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Speedtest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Speedtest[]    findAll()
 * @method Speedtest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpeedtestRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Speedtest::class);
    }

    public function save(Speedtest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Speedtest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByDays(int $days)
    {
        $date = new DateTime();
        $date->sub(DateInterval::createFromDateString("{$days} day"));
        $dateFormat = $date->format('Y-m-d H:i:s');

        return $this->createQueryBuilder('s')
                        ->select('s.id, s.datetime, s.downloadBandwidth, s.uploadBandwidth')
                        ->andWhere('s.datetime >= :date')
                        ->setParameter('date', $dateFormat)
                        ->orderBy('s.datetime', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function findByDateTime(DateTime $dateTime): ?Speedtest
    {
        return $this->createQueryBuilder('s')
                        ->where('s.datetime = :date')
                        ->setParameter('date', $dateTime->format('Y-m-d H:i:s'))
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Speedtest[] Returns an array of Speedtest objects
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
//    public function findOneBySomeField($value): ?Speedtest
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
