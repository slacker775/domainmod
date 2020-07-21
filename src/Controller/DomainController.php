<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DomainRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Domain;
use Symfony\Component\HttpFoundation\Response;
use App\Form\DomainType;
use App\Repository\RegistrarRepository;
use App\Repository\CreationTypeRepository;
use App\Repository\UserRepository;
use App\Entity\Registrar;
use App\Entity\RegistrarAccount;
use App\Entity\Dns;
use App\Entity\Hosting;
use App\Entity\Owner;
use League\Csv\Writer;
use App\Repository\RegistrarAccountRepository;

/**
 *
 * @Route("/domain")
 *
 */
class DomainController extends AbstractController
{

    private DomainRepository $repository;

    private RegistrarAccountRepository $accountRepository;

    private RegistrarRepository $registrarRepository;

    public function __construct(DomainRepository $repository, RegistrarAccountRepository $accountRepository, RegistrarRepository $registrarRepository)
    {
        $this->repository = $repository;
        $this->accountRepository = $accountRepository;
        $this->registrarRepository = $registrarRepository;
    }

    /*
     * This function returns all domains based on filters that may be
     * present in the request
     */
    private function getDomains(array $filters): ?array
    {
        $domains = $this->repository->findBy($filters, [
            'name' => 'ASC'
        ]);
        return $domains;
    }

    private function getRequestFilters(Request $request): array
    {
        $filters = [];
        $registrarId = $request->query->getInt('registrar');
        if ($registrarId != 0) {
            $filters['registrar'] = $this->getDoctrine()
                ->getRepository(Registrar::class)
                ->find($registrarId);
        }
        $accountId = $request->query->getInt('account');
        if ($accountId != 0) {
            $filters['account'] = $this->getDoctrine()
                ->getRepository(RegistrarAccount::class)
                ->find($accountId);
        }
        $dnsId = $request->query->getInt('dns');
        if ($dnsId != 0) {
            $filters['dns'] = $this->getDoctrine()
                ->getRepository(Dns::class)
                ->find($dnsId);
        }
        $hostingId = $request->query->getInt('hosting');
        if ($hostingId != 0) {
            $filters['hostingProvider'] = $this->getDoctrine()
                ->getRepository(Hosting::class)
                ->find($hostingId);
        }
        $ownerId = $request->query->getInt('owner');
        if ($ownerId != 0) {
            $filters['owner'] = $this->getDoctrine()
                ->getRepository(Owner::class)
                ->find($ownerId);
        }
        $tld = $request->query->get('tld');
        if ($tld != null) {
            $filters['tld'] = $tld;
        }
        return $filters;
    }

    /**
     *
     * @Route("/", name="domain_index")
     */
    public function index(Request $request)
    {
        $filters = $this->getRequestFilters($request);

        $domains = $this->getDomains($filters);

        $totalCost = 0;
        foreach ($domains as $d) {
            $totalCost += $d->getTotalCost();
        }

        return $this->render('domain/index.html.twig', [
            'controller_name' => 'DomainController',
            'domains' => $domains,
            'domainCount' => count($domains),
            'registrarCount' => $this->registrarRepository->count([]),
            'registrarAccountCount' => $this->accountRepository->count([]),
            'totalCost' => $totalCost,
            'sortBy' => 'dn_a',
            'filters' => $filters
        ]);
    }

    /**
     *
     * @Route("/new", name="domain_new", methods={"GET","POST"})
     */
    public function new(Request $request, RegistrarRepository $registrarRepository, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $domain = new Domain();

        $settings = $this->getUser()->getSettings();
        $domain->setRegistrar($settings->getDefaultRegistrar())
            ->setAccount($settings->getDefaultRegistrarAccount())
            ->setCategory($settings->getDefaultCategoryDomains())
            ->setDns($settings->getDefaultDns())
            ->setIp($settings->getDefaultIpAddressDomains())
            ->setHostingProvider($settings->getDefaultHost());
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domain->setTld()
                ->setOwner($domain->getAccount()
                ->getOwner())
                ->setRegistrar($domain->getAccount()
                ->getRegistrar())
                ->setFee($registrarRepository->getFeeByTld($domain->getAccount()
                ->getRegistrar(), $domain->getTld()))
                ->setCreationType($creationTypeRepository->findByName('Manual'));
            $this->repository->save($domain);

            $this->addFlash('success', sprintf('Domain %s Added', $domain->getName()));
            return $this->redirectToRoute('domain_index');
        }

        return $this->render('domain/new.html.twig', [
            'domain' => $domain,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/raw", name="domain_raw")
     */
    public function raw(DomainRepository $repository)
    {
        return $this->render('domain/raw.html.twig', [
            'domains' => $repository->findAll()
        ]);
    }

    /**
     *
     * @Route("/export", name="domain_export")
     */
    public function export(Request $request)
    {
        $domains = $this->getDomains($request);

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne([
            'domain',
            'tld',
            'owner',
            'registrar',
            'account',
            'expiration'
        ]);
        foreach ($domains as $d) {
            $csv->insertOne([
                $d->getDomain(),
                $d->getTld(),
                $d->getOwner(),
                $d->getRegistrar(),
                $d->getAccount(),
                $d->getExpiryDate()
                    ->format('m/d/Y')
            ]);
        }

        return new Response($csv->getContent(), 200, [
            'Content-Encoding' => 'none',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="domain-export.csv"',
            'Content-Description' => 'Domain Export'
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="domain_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Domain $domain, RegistrarRepository $registrarRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $domain->setTld()
                ->setOwner($domain->getAccount()
                ->getOwner())
                ->setRegistrar($domain->getAccount()
                ->getRegistrar())
                ->setFee($registrarRepository->getFeeByTld($domain->getAccount()
                ->getRegistrar(), $domain->getTld()));
            $this->addFlash('success', sprintf('Domain %s Updated', $domain->getName()));
            return $this->redirectToRoute('domain_index');
        }

        return $this->render('domain/edit.html.twig', [
            'domain' => $domain,
            'form' => $form->createView(),
            'minDate' => gmdate("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") - 9)),
            'maxDate' => gmdate("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") + 10))
        ]);
    }

    /**
     *
     * @Route("/{id}", name="domain_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Domain $domain): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $domain->getId(), $request->request->get('_token'))) {
            $this->repository->remove($domain);
            $this->addFlash('success', sprintf('Domain %s Deleted', $domain->getName()));
        }

        return $this->redirectToRoute('domain_index');
    }
}
