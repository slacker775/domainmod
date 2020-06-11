<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApiRegistrarRepository;
use App\Repository\RegistrarAccountRepository;
use App\Entity\RegistrarAccount;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DomainQueueList;
use App\Service\DomainQueue;

/**
 *
 * @Route("/queue")
 *
 */
class QueueController extends AbstractController
{

    private RegistrarAccountRepository $accountRepository;

    public function __construct(RegistrarAccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     *
     * @Route("/", name="queue")
     */
    public function index()
    {
        return $this->render('queue/index.html.twig', [
            'domainsInQueue' => false,
            'domainsInListQueue' => false
        ]);
    }

    /**
     *
     * @Route("/intro", name="queue_intro")
     */
    public function intro(ApiRegistrarRepository $repository)
    {
        return $this->render('queue/intro.html.twig', [
            'apiRegistrars' => $repository->findBy([], [
                'name' => 'ASC'
            ])
        ]);
    }

    /**
     *
     * @Route("/add/{id}", name="queue_add", defaults={"id"=null}, methods={"GET","POST"})
     */
    public function add(Request $request, RegistrarAccount $account = null)
    {
        if ($request->isMethod('POST') === true) {
            if ($account === null) {
                throw new \InvalidArgumentException('Registrar Account must be specified!');
            }
            $queueItem = new DomainQueueList();
            $queueItem->setAccount($account)
                ->setRegistrar($account->getRegistrar())
                ->setOwner($account->getOwner())
                ->setApiRegistrar($account->getRegistrar()
                ->getApiRegistrar())
                ->setCreatedBy($this->getUser());
            $this->getDoctrine()
                ->getManager()
                ->persist($queueItem);
            return $this->redirectToRoute('queue');
        }
        $accounts = $this->accountRepository->getAccountsWithApi();
        return $this->render('queue/add.html.twig', [
            'accounts' => $accounts,
            'account' => $account
        ]);
    }
    
    /**
     * @Route("/run")
     */
    public function run(DomainQueue $service)
    {
        $service->run();
        return $this->redirectToRoute('queue');
    }
}
