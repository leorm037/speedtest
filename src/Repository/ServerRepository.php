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

use App\DTO\PaginacaoDTO;
use App\Entity\Server;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Server>
 */
class ServerRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Server::class);
    }

    public function save(Server $server, bool $flush = true): void
    {
        $this->getEntityManager()->persist($server);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveSelected(int $id, bool $selected): void
    {
        $speedtestServerSelected = $this->speedtestServerSelected();

        if (null !== $speedtestServerSelected) {
            $speedtestServerSelected->setIsSelected(false);
            $this->save($speedtestServerSelected);

            if (false == $selected) {
                return;
            }
        }

        /** @var Server $server */
        $server = $this->find($id);
        $server->setIsSelected(true);
        $this->save($server);
    }

    public function speedtestServerSelected(): ?Server
    {
        return $this->createQueryBuilder('s')
                        ->where('s.isSelected = :isSelected')
                        ->setParameter('isSelected', true)
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    /**
     * @return Server[]
     */
    public function list(Server $serverFilter, int $registrosPorPagina = 10, int $paginaAtual = 1)
    {
        $pagina = ($paginaAtual - 1) * $registrosPorPagina;

        $query = $this->createQueryBuilder('s')
                ->setFirstResult($pagina)
                ->setMaxResults($registrosPorPagina)
        ;

        if ($serverFilter->getName()) {
            $query
                    ->andWhere('s.name LIKE :name')
                    ->setParameter('name', '%' . $serverFilter->getName() . '%')
            ;
        }

        return new PaginacaoDTO(new Paginator($query), $registrosPorPagina, $paginaAtual);
    }

    public function locations()
    {
        return $this->createQueryBuilder('s')
                        ->select('DISTINCT s.location')
                        ->orderBy('s.location', 'ASC')
                        ->getQuery()
                        ->getSingleColumnResult()
        ;
    }

    /**
     * 
     * @return array<int,string>
     */
    public function countries()
    {
        return $this->createQueryBuilder('s')
                        ->select('DISTINCT s.country')
                        ->orderBy('s.country', 'ASC')
                        ->getQuery()
                        ->getSingleColumnResult();
    }

    //    /**
    //     * @return Server[] Returns an array of Server objects
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
    //    public function findOneBySomeField($value): ?Server
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
