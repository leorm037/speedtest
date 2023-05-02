<?php

namespace App\Repository;

use App\Entity\SpeedtestServer;
use App\Entity\User;
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

    public function saveSelected(int $id, bool $selected, User $user): ?SpeedtestServer
    {
        $speedtestServerSelected = $this->speedtestServerSelected();

        if (null !== $speedtestServerSelected) {
            $speedtestServerSelected->setSelected(false);
            $speedtestServerSelected->setUpdatedUser($user);
            $this->save($speedtestServerSelected, true);

            if (false === $selected) {
                return $speedtestServerSelected;
            }
        }

        $speedtestServer = $this->findById($id);
        $speedtestServer->setSelected(true);
        $speedtestServer->setUpdatedUser($user);
        $this->save($speedtestServer, true);

        return $speedtestServer;
    }

    /**
     * 
     * @return SpeedtestServer[]
     */
    public function list()
    {
        return $this->createQueryBuilder('ss')
                        ->orderBy('ss.name', 'ASC')
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
