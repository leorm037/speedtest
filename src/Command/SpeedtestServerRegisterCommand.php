<?php

namespace App\Command;

use App\Factory\SpeedtestServerFactory;
use App\Repository\SpeedtestServerRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
    private LoggerInterface $logger;

    public function __construct(SpeedtestServerRepository $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('list', 'l', InputOption::VALUE_NONE, 'List registered servers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('list')) {
            return $this->listServer($io);
        }

        return $this->addNewServer($io);
    }

    private function addNewServer(SymfonyStyle $io): int
    {
        try {
            $json = shell_exec(self::SPEEDTEST_SERVER_COMMAND);

            if (null === $json) {
                return $this->messageJsonNull($io);
            }

            $result = json_decode($json);

            $io->title("List servers from Speedtest");

            foreach ($result->servers as $server) {
                $speedtestServer = SpeedtestServerFactory::build($server);

                if ($this->repository->find($server->id)) {
                    $io->text(sprintf(" Name: %s", $speedtestServer->getName()));
                } else {
                    $this->repository->save($speedtestServer, true);
                    $io->info(sprintf(" Name: (%s) %s", $speedtestServer->getId(), $speedtestServer->getName()));
                }
            }
            $io->newLine();
        } catch (Exception $e) {
            return $this->messageException($io, $e);
        }

        return Command::SUCCESS;
    }

    private function listServer(SymfonyStyle $io)
    {
        $io->title("List registered servers");
        foreach ($this->repository->findBy([],['name' => 'ASC']) as $server) {
            $io->text(
                    sprintf(
                            " Name: (%s) %s, location %s - %s",
                            $server->getId(),
                            $server->getName(),
                            $server->getLocation(),
                            $server->getCountry()
                    )
            );
        }
        $io->newLine();
        return Command::SUCCESS;
    }

    private function messageJsonNull(SymfonyStyle $io)
    {
        $message = "Unable to retrieve list of Speedtest service servers. Check your internet connection.";
        $io->error($message);
        $this->logger->error($message . " return NULL");

        return Command::FAILURE;
    }

    private function messageException(SymfonyStyle $io, Exception $e)
    {
        $message = "Error trying to save list of new servers.";
        $io->error($message);
        $this->logger->error($message . $e->getTraceAsString());
        return Command::FAILURE;
    }

}
