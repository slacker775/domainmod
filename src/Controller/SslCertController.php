<?php
namespace App\Controller;

use App\Entity\SslCert;
use App\Form\SslCertType;
use App\Repository\SslCertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreationTypeRepository;

/**
 *
 * @Route("/ssl/cert")
 */
class SslCertController extends AbstractController
{

    private SslCertRepository $repository;

    public function __construct(SslCertRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @Route("/", name="ssl_cert_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslCerts = $this->repository->findAll();

        return $this->render('ssl_cert/index.html.twig', [
            'ssl_certs' => $sslCerts
        ]);
    }

    /**
     *
     * @Route("/export", name="ssl_cert_export")
     */
    public function export()
    {
        return $this->redirectToRoute('ssl_cert_index');
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

            $fees = $sslCert->getSslProvider()->getFee();
            $sslCert->setFee($fees)->setTotalCost($fees !== null ? $fees->getInitialFee() : 0);

            $this->repository->save($sslCert);

            $this->addFlash('success', sprintf('SSL Certificate %s Added', $sslCert->getName()));
            return $this->redirectToRoute('ssl_cert_index');
        }

        return $this->render('ssl_cert/new.html.twig', [
            'ssl_cert' => $sslCert,
            'form' => $form->createView()
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
            'form' => $form->createView()
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
