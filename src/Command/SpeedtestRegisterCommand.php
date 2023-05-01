<?php

namespace App\Command;

use App\Entity\Speedtest;
use App\Factory\SpeedtestFactory;
use App\Repository\SpeedtestRepository;
use App\Repository\SpeedtestServerRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
            name: 'speedtest:register',
            description: 'Records the connection speed.',
    )]
class SpeedtestRegisterCommand extends Command
{

    private const SPEEDTEST_COMMAND = '/usr/bin/speedtest --format=json';

    private SpeedtestServerRepository $speedtestServerRepository;
    private SpeedtestRepository $speedtestRepository;
    private LoggerInterface $logger;

    public function __construct(SpeedtestRepository $speedtestRepository, SpeedtestServerRepository $speedtestServerRepository, LoggerInterface $logger)
    {
        $this->speedtestServerRepository = $speedtestServerRepository;
        $this->speedtestRepository = $speedtestRepository;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure(): void
    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $speedtestServerSelected = $this->speedtestServerRepository->speedtestServerSelected();

        if (null !== $speedtestServerSelected) {
            $json = shell_exec(self::SPEEDTEST_COMMAND . " --server-id={$speedtestServerSelected->getId()}");
        } else {
            $json = shell_exec(self::SPEEDTEST_COMMAND);
        }

        $result = json_decode($json);
        
        if ("result" !== $result->type) {
            $this->logger->error($json);
            return Command::FAILURE;
        }

        $speedtest = SpeedtestFactory::build($result);

        if (!$this->speedtestServerRepository->exist($speedtest->getSpeedtestServer()->getId())) {
            $this->speedtestServerRepository->save($speedtest->getSpeedtestServer(), true);
        }

        $speedtest->setSpeedtestServer($this->speedtestServerRepository->find($speedtest->getSpeedtestServer()->getId()));

        $this->speedtestRepository->save($speedtest, true);
        
        $this->messageSpeedtest($io, $speedtest);

        return Command::SUCCESS;
    }

    private function messageSpeedtest(SymfonyStyle $io, Speedtest $speedtest)
    {
        $io->title("Speedtest register");

        $io->text("Id:       {$speedtest->getId()}");
        $io->text("Date:     {$speedtest->getDatetime()->format('d/m/Y H:i:s')}");
        $io->text("Download: {$speedtest->getDownloadBandwidth()} bytes");
        $io->text("Upload:   {$speedtest->getUploadBandwidth()} bytes");
        $io->text("Server:   {$speedtest->getSpeedtestServer()->getId()} - {$speedtest->getSpeedtestServer()->getName()}");
        $io->text("Location: {$speedtest->getSpeedtestServer()->getLocation()}");
        $io->text("Country:  {$speedtest->getSpeedtestServer()->getCountry()}");

        $io->newLine();
    }

}
