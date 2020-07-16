<?php
namespace App\Controller;

use App\Entity\SslCertType;
use App\Form\SslCertTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SslCertTypeRepository;

/**
 *
 * @Route("/ssl/type")
 */
class SslCertTypeController extends AbstractController
{

    private SslCertTypeRepository $repository;

    public function __construct(SslCertTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @Route("/", name="ssl_cert_type_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslCertTypes = $this->repository->findAll();

        return $this->render('ssl_cert_type/index.html.twig', [
            'ssl_cert_types' => $sslCertTypes
        ]);
    }

    /**
     *
     * @Route("/new", name="ssl_cert_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $sslCertType = new SslCertType();
        $form = $this->createForm(SslCertTypeType::class, $sslCertType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($sslCertType);

            $this->addFlash('success', sprintf('SSL Type %s Added', $sslCertType->getType()));
            return $this->redirectToRoute('ssl_cert_type_index');
        }

        return $this->render('ssl_cert_type/new.html.twig', [
            'ssl_cert_type' => $sslCertType,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/export", name="ssl_cert_type_export")
     */
    public function export(): Response
    {
        return $this->redirectToRoute('ssl_cert_type_index');
    }

    /**
     *
     * @Route("/{id}/edit", name="ssl_cert_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslCertType $sslCertType): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(SslCertTypeType::class, $sslCertType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', sprintf('SSL Type %s Updated', $sslCertType->getType()));
            return $this->redirectToRoute('ssl_cert_type_index');
        }

        return $this->render('ssl_cert_type/edit.html.twig', [
            'ssl_cert_type' => $sslCertType,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="ssl_cert_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslCertType $sslCertType): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $sslCertType->getId(), $request->request->get('_token'))) {
            $this->repository->remove($sslCertType);
            $this->addFlash('success', sprintf('SSL Type %s Deleted', $sslCertType->getType()));
        }

        return $this->redirectToRoute('ssl_cert_type_index');
    }
}
