<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Result;
use App\Helper\DateTimeHelper;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Result>
 */
class ResultRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Result::class);
    }

    public function save(Result $result, bool $flush = true): void
    {
        $this->getEntityManager()->persist($result);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Result[]
     */
    public function findByDias(int $dias)
    {
        $date = DateTimeHelper::currentDateTime('UCT');
        $date->sub(DateInterval::createFromDateString("{$dias} day"));

        $dateFormat = $date->format('Y-m-d H:i:s');

        return $this->createQueryBuilder('r')
                        ->select('r.id,r.timestamp,r.downloadBandwidth,r.uploadBandwidth')
                        ->andWhere('r.timestamp >= :date')
                        ->setParameter('date', $dateFormat)
                        ->orderBy('r.timestamp', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function findByDateTime(DateTime $dateTime): ?Result
    {
        $format = 'Y-m-d H:i:s';

        $dateTimeString = $dateTime->format($format);

        return $this->createQueryBuilder('r')
                        ->where('r.timestamp = :date')
                        ->setParameter('date', $dateTimeString)
                        ->orderBy('r.timestamp', 'DESC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

    //    /**
    //     * @return Result[] Returns an array of Result objects
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
    //    public function findOneBySomeField($value): ?Result
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
