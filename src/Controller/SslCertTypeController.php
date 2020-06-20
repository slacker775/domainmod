<?php

namespace App\Controller;

use App\Entity\SslCertType;
use App\Form\SslCertTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ssl/type")
 */
class SslCertTypeController extends AbstractController
{
    /**
     * @Route("/", name="ssl_cert_type_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslCertTypes = $this->getDoctrine()
            ->getRepository(SslCertType::class)
            ->findAll();

        return $this->render('ssl_cert_type/index.html.twig', [
            'ssl_cert_types' => $sslCertTypes,
        ]);
    }

    /**
     * @Route("/new", name="ssl_cert_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sslCertType = new SslCertType();
        $form = $this->createForm(SslCertTypeType::class, $sslCertType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sslCertType);
            $entityManager->flush();

            return $this->redirectToRoute('ssl_cert_type_index');
        }

        return $this->render('ssl_cert_type/new.html.twig', [
            'ssl_cert_type' => $sslCertType,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/export", name="ssl_cert_type_export")
     */
    public function export(): Response
    {
        return $this->redirectToRoute('ssl_cert_type_index');
    }

    /**
     * @Route("/{id}", name="ssl_cert_type_show", methods={"GET"})
     */
    public function show(SslCertType $sslCertType): Response
    {
        return $this->render('ssl_cert_type/show.html.twig', [
            'ssl_cert_type' => $sslCertType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ssl_cert_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslCertType $sslCertType): Response
    {
        $form = $this->createForm(SslCertTypeType::class, $sslCertType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ssl_cert_type_index');
        }

        return $this->render('ssl_cert_type/edit.html.twig', [
            'ssl_cert_type' => $sslCertType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_cert_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslCertType $sslCertType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sslCertType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sslCertType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssl_cert_type_index');
    }
}
