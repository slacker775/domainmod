<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\Maintenance;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Scheduler;
use Symfony\Component\Stopwatch\Stopwatch;

class MaintenanceCommand extends Command
{

    public const SCHEDULER_SLUG = 'cleanup';

    protected static $defaultName = 'app:maintenance';

    private Maintenance $service;

    private EntityManagerInterface $entityManager;

    public function __construct(Maintenance $service, EntityManagerInterface $entityManager)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Run database maintenance');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $schedule = $this->entityManager->getRepository(Scheduler::class)->findOneBySlug(self::SCHEDULER_SLUG);
        if ($schedule === null) {
            throw new \Exception('Unable to locate maintenance job!');
        }

        $stopwatch = new Stopwatch();

        $stopwatch->start(self::SCHEDULER_SLUG);
        $this->service->maintenance();
        $event = $stopwatch->stop(self::SCHEDULER_SLUG);

        $timestamp = new \DateTime();
        $duration = $event->getDuration() / 1000;
        $schedule->setRunning(false)
            ->setLastRun($timestamp)
            ->setLastDuration(sprintf("%ds", $duration));

        $this->entityManager->persist($schedule);
        $this->entityManager->flush();

        $io->success('Maintenance completed successfully');

        return 0;
    }
}
