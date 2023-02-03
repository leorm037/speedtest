<?php

namespace App\Command;

use App\Factory\SpeedtestServerFactory;
use App\Repository\SpeedtestServerRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
            name: 'speedtest:server:register',
            description: 'Register the Speedtest servers.',
    )]
class SpeedtestServerRegisterCommand extends Command
{

    private const SPEEDTEST_SERVER_COMMAND = '/usr/bin/speedtest --servers -f json';

    private SpeedtestServerRepository $repository;

    public function __construct(SpeedtestServerRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    protected function configure(): void
    {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $json = shell_exec(self::SPEEDTEST_SERVER_COMMAND);
            $result = json_decode($json);

            foreach ($result->servers as $server) {
                $speedtestServer = SpeedtestServerFactory::build($server);

                if ($this->repository->find($server->id)) {
                    $io->text(sprintf(" Name: %s", $speedtestServer->getName()));
                } else {
                    $this->repository->save($speedtestServer, true);
                    $io->info(sprintf(" Name: (%s) %s", $speedtestServer->getId(),$speedtestServer->getName()));
                }
            }
        } catch (Exception $e) {
            $io->error($e);
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

}
