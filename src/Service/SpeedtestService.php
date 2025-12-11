<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\Service;

use App\Entity\Result;
use App\Entity\Server;
use App\Factory\ResultFactory;
use App\Repository\ResultRepository;
use App\Repository\ServerRepository;
use Exception;
use Psr\Log\LoggerInterface;

class SpeedtestService
{
    public function __construct(
        private string $speedtestPath,
        private LoggerInterface $logger,
        private ServerRepository $serverRepository,
        private ResultRepository $resultRepository,
    ) {
    }

    public function testSpeed(): Result|string
    {
        $server = $this->serverRepository->findOneBy(['isSelected' => true]);

        if ($server instanceof Server) {
            return $this->registerServerSelected($server);
        }

        return $this->register();
    }

    public function registerServerSelected(Server $server): Result|string
    {
        try {
            $command = $this->speedtestPath.' --server-id='.$server->getId();

            $json = shell_exec($command);

            $result = ResultFactory::fromJson($json);

            $result->setServer($server);

            $this->resultRepository->save($result);

            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function register(): Result|string
    {
        try {
            $json = shell_exec($this->speedtestPath);

            $result = ResultFactory::fromJson($json);

            $server = $this->serverRepository->find($result->getServer()->getId());

            if (null == $server) {
                $server = $result->getServer();
                $this->serverRepository->save($server);
            }

            $result->setServer($server);

            $this->resultRepository->save($result);

            return $result;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), [
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'stack trace' => $e->getTraceAsString(),
            ]);

            return $e->getMessage();
        }
    }
}
