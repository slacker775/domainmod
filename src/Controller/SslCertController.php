<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\SslCert;
use App\Form\SslCertFilterType;
use App\Form\SslCertType;
use App\Repository\CreationTypeRepository;
use App\Repository\DomainRepository;
use App\Repository\SslAccountRepository;
use App\Repository\SslCertRepository;
use App\Repository\SslProviderRepository;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/ssl/cert")
 */
class SslCertController extends AbstractController
{

    private SslCertRepository $repository;

    private SslProviderRepository $sslProviderRepository;

    private SslAccountRepository $sslAccountRepository;

    private DomainRepository $domainRepository;

    public function __construct(SslCertRepository $repository, SslProviderRepository $sslProviderRepository, SslAccountRepository $sslAccountRepository, DomainRepository $domainRepository)
    {
        $this->repository = $repository;
        $this->sslProviderRepository = $sslProviderRepository;
        $this->sslAccountRepository = $sslAccountRepository;
        $this->domainRepository = $domainRepository;
    }

    /**
     *
     * @Route("/", name="ssl_cert_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SslCertFilterType::class, null, ['method' => 'GET', 'csrf_protection' => false]);
        $form->handleRequest($request);

        $filters = $this->getFormFilters($form);
        $sslCerts = $this->repository->getCertsWithFilter($filters);

        return $this->render('ssl_cert/index.html.twig', [
            'ssl_certs' => $sslCerts,
            'form'      => $form->createView(),
            'sslProviderCount' => $this->sslProviderRepository->count([]),
            'sslAccountCount' => $this->sslAccountRepository->count([]),
            'domainCount' => $this->domainRepository->count([]),
        ]);
    }

    private function getFormFilters(FormInterface $form): array
    {
        $filters = $form->getData();

        if ($filters === null) {
            return [];
        }
        $filters = array_filter($filters, function ($var) {
            return $var !== null;
        });
        return $filters;
    }

    /**
     *
     * @Route("/export", name="ssl_cert_export")
     */
    public function export(Request $request): Response
    {
        $form = $this->createForm(SslCertFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $filters = $this->getFormFilters($form);
        $certs = $this->repository->getCertsWithFilter($filters);

        dump($certs);
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne([
            'name',
            'domain',
            'owner',
            'registrar',
            'account',
            'cost',
            'expiration',
            'ip',
            'type',
            'category',
            'status',
        ]);
        foreach ($certs as $cert) {
            $csv->insertOne([
                $cert->getName(),
                $cert->getDomain(),
                $cert->getOwner(),
                $cert->getSslProvider(),
                $cert->getAccount(),
                $cert->getTotalCost(),
                $cert->getExpiryDate()
                    ->format('m/d/Y'),
                $cert->getIp()
                    ->getIp(),
                $cert->getType(),
                $cert->getCategory(),
                $cert->getStatus(),
            ]);
        }

        return new Response($csv->getContent(), 200, [
            'Content-Encoding'    => 'none',
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="domain-export.csv"',
            'Content-Description' => 'Domain Export'
        ]);
    }

    /**
     *
     * @Route("/raw", name="ssl_cert_raw")
     */
    public function raw(Request $request): Response
    {
        $form = $this->createForm(SslCertFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $filters = $this->getFormFilters($form);

        return $this->render('ssl_cert/raw.html.twig', [
            'certs' => $this->repository->getCertsWithFilter($filters)
        ], new Response(null, 200, ['Content-Type' => 'text/plain']));
    }

    /**
     *
     * @Route("/new", name="ssl_cert_new", methods={"GET","POST"})
     */
    public function new(Request $request, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $sslCert = new SslCert();
        $form = $this->createForm(SslCertType::class, $sslCert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sslCert->setOwner($sslCert->getAccount()
                ->getOwner())
                ->setSslProvider($sslCert->getAccount()
                    ->getSslProvider())
                ->setCreationType($creationTypeRepository->findByName('Manual'));

            $fees = $sslCert->getSslProvider()
                ->getFee();
            $sslCert->setFee($fees)
                ->setTotalCost($fees !== null ? $fees->getInitialFee() : 0);

            $this->repository->save($sslCert);

            $this->addFlash('success', sprintf('SSL Certificate %s Added', $sslCert->getName()));
            return $this->redirectToRoute('ssl_cert_index');
        }

        return $this->render('ssl_cert/new.html.twig', [
            'ssl_cert' => $sslCert,
            'form'     => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="ssl_cert_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslCert $sslCert): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(SslCertType::class, $sslCert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', sprintf('SSL Certificate %s Updated', $sslCert->getName()));

            return $this->redirectToRoute('ssl_cert_index');
        }

        return $this->render('ssl_cert/edit.html.twig', [
            'ssl_cert' => $sslCert,
            'form'     => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="ssl_cert_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslCert $sslCert, SslCertRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $sslCert->getId(), $request->request->get('_token'))) {
            $repository->remove($sslCert);
            $this->addFlash('success', sprintf('SSL Certificate %s Deleted', $sslCert->getName()));
        }

        return $this->redirectToRoute('ssl_cert_index');
    }
}
