<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Registrar;
use App\Entity\RegistrarAccount;
use App\Entity\Domain;
use App\Entity\Owner;

class MergeOwnersCommand extends Command
{

    protected static $defaultName = 'app:merge:owners';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $ownerList = [];
        $owners = $this->entityManager->getRepository(Owner::class)->findBy([],['created' => 'ASC']);
        foreach($owners as $r) {
            $ownerList[$r->getName()][] = $r;
        }
        
        foreach($ownerList as $n => $v) {
            if(count($v) > 1) {
                $io->writeln(sprintf('Owner %s has %d copies', $n, count($v)));
                
                for($i=1; $i < count($v); $i++) {
                    $this->mergeOwner($v[0], $v[$i]);
                }
            }
        }
        
        $this->entityManager->flush();

        return 0;
    }
    
    private function mergeOwner(Owner $original, Owner $duplicate)
    {
        $accounts = $this->entityManager->getRepository(RegistrarAccount::class)->findBy(['owner' => $duplicate]);
        foreach($accounts as $a) {
            $a->setOwner($original);
            $this->entityManager->persist($a);
        }
        $domains = $this->entityManager->getRepository(Domain::class)->findBy(['owner' => $duplicate]);
        foreach($domains as $d) {
            $d->setOwner($original);
            $this->entityManager->persist($d);
        }
        $this->entityManager->remove($duplicate);
    }
}
