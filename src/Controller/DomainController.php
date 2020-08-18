<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Form\DomainFilterType;
use App\Form\DomainType;
use App\Repository\CreationTypeRepository;
use App\Repository\DomainRepository;
use App\Repository\RegistrarAccountRepository;
use App\Repository\RegistrarRepository;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     *
     * @Route("/", name="domain_index")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(DomainFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $filters = $this->getFormFilters($form);
        $domains = $this->repository->getDomainsWithFilter($filters);

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
            'form' => $form->createView()
        ]);
    }

    private function getFormFilters(FormInterface $form): array
    {
        $filters = $form->getData();

        if($filters === null) {
            return [];
        }
        $filters = array_filter($filters, function ($var) {
            return $var !== null;
        });
        return $filters;
    }

    /**
     *
     * @Route("/new", name="domain_new", methods={"GET","POST"})
     */
    public function new(Request $request, RegistrarRepository $registrarRepository, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $domain = new Domain();

        $settings = $this->getUser()
            ->getSettings();
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
    public function raw(Request $request): Response
    {
        $form = $this->createForm(DomainFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $filters = $this->getFormFilters($form);

        return $this->render('domain/raw.html.twig', [
            'domains' => $this->repository->getDomainsWithFilter($filters)
        ], new Response(null, 200, ['Content-Type' => 'text/plain']));
    }

    /**
     *
     * @Route("/export", name="domain_export")
     */
    public function export(Request $request): Response
    {
        $form = $this->createForm(DomainFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $filters = $this->getFormFilters($form);
        $domains = $this->repository->getDomainsWithFilter($filters);

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne([
            'domain',
            'tld',
            'owner',
            'registrar',
            'account',
            'expiration',
            'category',
            'function',
            'totalcost',
            'autorenew',
            'privacy',
        ]);
        foreach ($domains as $d) {
            $csv->insertOne([
                $d->getName(),
                $d->getTld(),
                $d->getOwner(),
                $d->getRegistrar(),
                $d->getAccount(),
                $d->getExpiryDate()
                    ->format('m/d/Y'),
                $d->getCategory(),
                $d->getFunction(),
                $d->getTotalCost(),
                $d->isAutoRenew() ? 'true' : 'false',
                $d->isPrivacy() ? 'true' : 'false',
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
