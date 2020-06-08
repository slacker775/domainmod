<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApiRegistrarRepository;
use App\Repository\RegistrarAccountRepository;
use App\Entity\RegistrarAccount;

/**
 * @Route("/queue")
 *
 */
class QueueController extends AbstractController
{
    /**
     * @Route("/", name="queue")
     */
    public function index()
    {
        return $this->render('queue/index.html.twig', [
            'domainsInQueue' => false,
            'domainsInListQueue' => false,
        ]);
    }
    
    /**
     * @Route("/intro", name="queue_intro")
     */
    public function intro(ApiRegistrarRepository $repository)
    {
        return $this->render('queue/intro.html.twig', [
            'apiRegistrars' => $repository->findBy([],['name' => 'ASC'])
        ]);
    }
    
    /**
     * @Route("/add/{id}", name="queue_add", defaults={"id"=null})
     */
    public function add(RegistrarAccount $account = null, RegistrarAccountRepository $accountRepository)
    {
        $accounts = $accountRepository->getAccountsWithApi();
        return $this->render('queue/add.html.twig', [
            'accounts' => $accounts,
            'account' => $account,
        ]);
    }
}
