<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\Command;

use App\Entity\Result;
use App\Service\SpeedtestService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'speedtest:register',
    description: 'Registra a velocidade de conexão.',
)]
class SpeedtestRegisterCommand extends Command
{
    public function __construct(
        private SpeedtestService $speedtestServer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->info('Iniciando a medição, aguarde ...');

        $result = $this->speedtestServer->testSpeed();

        if ($result instanceof Result) {
            $io->success('Medição realizada com sucesso');

            return Command::SUCCESS;
        }

        $io->error($result);

        return Command::FAILURE;
    }
}
