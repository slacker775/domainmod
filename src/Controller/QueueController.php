<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApiRegistrarRepository;
use App\Repository\RegistrarAccountRepository;
use App\Entity\RegistrarAccount;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DomainQueueList;
use App\Entity\DomainQueue as DomainQueueEntity;
use App\Service\DomainQueue;
use App\Repository\DomainQueueListRepository;
use App\Repository\DomainQueueRepository;

/**
 *
 * @Route("/queue")
 *
 */
class QueueController extends AbstractController
{

    private RegistrarAccountRepository $accountRepository;

    private DomainQueueListRepository $domainQueueListRepository;

    private DomainQueueRepository $domainQueueRepository;

    public function __construct(RegistrarAccountRepository $accountRepository, DomainQueueRepository $domainQueueRepository, DomainQueueListRepository $domainQueueListRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->domainQueueRepository = $domainQueueRepository;
        $this->domainQueueListRepository = $domainQueueListRepository;
    }

    /**
     *
     * @Route("/", name="queue")
     */
    public function index()
    {
        return $this->render('queue/index.html.twig', [
            'domainsInQueue' => $this->domainQueueRepository->findBy([], [
                'created' => 'DESC'
            ]),
            'domainsInListQueue' => $this->domainQueueListRepository->findBy([], [
                'created' => 'ASC'
            ])
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
     *
     * @Route("/run")
     */
    public function run(DomainQueue $service)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $service->run();
        return $this->redirectToRoute('queue');
    }

    /**
     *
     * @Route("/list/export", name="queue_export_lists")
     *
     */
    public function exportList()
    {
        return $this->redirectToRoute('queue');
    }

    /**
     *
     * @Route("/list/{id}/delete", name="queue_delete_list")
     *
     */
    public function deleteList(DomainQueueList $list)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->domainQueueListRepository->remove($list);
        return $this->redirectToRoute('queue');
    }

    /**
     *
     * @Route("/domain/export", name="queue_export_domains")
     *
     */
    public function exportDomain()
    {
        return $this->redirectToRoute('queue');
    }

    /**
     *
     * @Route("/domain/{id}/delete", name="queue_delete_domain")
     *
     */
    public function deleteDomain(DomainQueueEntity $queue)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->redirectToRoute('queue');
    }
}
