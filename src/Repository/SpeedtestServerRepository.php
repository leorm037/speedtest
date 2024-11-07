<?php

namespace App\Repository;

use App\Entity\SpeedtestServer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SpeedtestServer>
 *
 * @method SpeedtestServer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpeedtestServer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpeedtestServer[]    findAll()
 * @method SpeedtestServer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpeedtestServerRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpeedtestServer::class);
    }

    public function save(SpeedtestServer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveSelected(int $id, bool $selected): ?SpeedtestServer
    {
        $speedtestServerSelected = $this->speedtestServerSelected();

        if (null !== $speedtestServerSelected) {
            $speedtestServerSelected->setSelected(false);
            $this->save($speedtestServerSelected, true);

            if (false === $selected) {
                return $speedtestServerSelected;
            }
        }

        /** @var SpeedtestServer $speedtestServer */
        $speedtestServer = $this->findById($id);
        $speedtestServer->setSelected(true);
        $this->save($speedtestServer, true);

        return $speedtestServer;
    }

    /**
     * 
     * @return SpeedtestServer[]
     */
    public function list(string $sort = null, string $order = null)
    {
        $columns = ['datetime', 'host', 'port', 'location', 'name', 'country', 'selected', 'total'];

        $query = $this->createQueryBuilder('ss')
                ->select('ss AS speedtestServer')
                ->addSelect('COUNT(s.id) AS total')
        ;
        //->addSelect('MAX(s.downloadBandwidth) AS maxDownload, MIN(s.downloadBandwidth) AS minDownload, AVG(s.downloadBandwidth) AS avgDownload')
        //->addSelect('MAX(s.uploadBandwidth) AS maxUpload, MIN(s.uploadBandwidth) AS minUpload, AVG(s.uploadBandwidth) AS avgUpload')


        if (!in_array($sort, $columns)) {
            $query->orderBy('ss.name', 'ASC');
        } else {
            if (null == $order) {
                $order = "ASC";
            }
            if ('total' === $sort) {
                $query->orderBy("total", $order);
            } else {
                $query->orderBy("ss.{$sort}", $order);
            }
        }

        return $query->leftJoin('ss.speedtests', 's')
                        ->groupBy('ss.id')
                        ->getQuery()
                        ->getResult();
    }

    public function remove(SpeedtestServer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?SpeedtestServer
    {
        return $this->createQueryBuilder('ss')
                        ->where('ss.id = :id')
                        ->setParameter('id', $id)
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

    public function exist(int $id): bool
    {
        $count = $this->createQueryBuilder('ss')
                ->select('COUNT(ss.id)')
                ->where('ss.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleScalarResult()
        ;

        return ($count === 1) ? true : false;
    }

    public function speedtestServerSelected(): ?SpeedtestServer
    {
        return $this->createQueryBuilder('ss')
                        ->where('ss.selected = :selected')
                        ->setParameter('selected', true)
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

//    /**
//     * @return SpeedtestServer[] Returns an array of SpeedtestServer objects
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
//    public function findOneBySomeField($value): ?SpeedtestServer
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
