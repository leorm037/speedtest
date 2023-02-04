<?php

namespace App\Command;

use App\Entity\SpeedtestServer;
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
    private const SPEEDTEST_COMMAND = '/usr/bin/speedtest -f json';
    
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
        
        $json = shell_exec(self::SPEEDTEST_COMMAND);
        
        $result = json_decode($json);
        
        $speedtest = SpeedtestFactory::build($result);
        
        $speedtestServer = $speedtest->getSpeedtestServer();
        
        if (!$this->speedtestServerRepository->exist($speedtestServer->getId())) {
            $this->speedtestServerRepository->save($speedtestServer, true);
        } else {
            $speedtestServer = $this->speedtestServerRepository->find($speedtestServer->getId());
        }
        
        $speedtest->setSpeedtestServer($speedtestServer);

        $this->speedtestRepository->save($speedtest, true);
        
        $io->title("Speedtest register");
        
        $io->text("Id:       {$speedtest->getId()}");
        $io->text("Date:     {$speedtest->getDatetime()->format('d/m/Y H:i:s')}");
        $io->text("Download: {$speedtest->getDownloadBandwidth()} bytes");
        $io->text("Upload:   {$speedtest->getUploadBandwidth()} bytes");
        $io->text("Server:   {$speedtest->getSpeedtestServer()->getId()} - {$speedtest->getSpeedtestServer()->getName()}");
        $io->text("Location: {$speedtest->getSpeedtestServer()->getLocation()}");
        $io->text("Country:  {$speedtest->getSpeedtestServer()->getCountry()}");
        
        $io->newLine();
        
        return Command::SUCCESS;
    }
}
