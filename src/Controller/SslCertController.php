<?php

namespace App\Controller;

use App\Entity\SslCert;
use App\Form\SslCertType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ssl/cert")
 */
class SslCertController extends AbstractController
{
    /**
     * @Route("/", name="ssl_cert_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslCerts = $this->getDoctrine()
            ->getRepository(SslCert::class)
            ->findAll();

        return $this->render('ssl_cert/index.html.twig', [
            'ssl_certs' => $sslCerts,
        ]);
    }

    /**
     * @Route("/new", name="ssl_cert_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sslCert = new SslCert();
        $form = $this->createForm(SslCertType::class, $sslCert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sslCert);
            $entityManager->flush();

            return $this->redirectToRoute('ssl_cert_index');
        }

        return $this->render('ssl_cert/new.html.twig', [
            'ssl_cert' => $sslCert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_cert_show", methods={"GET"})
     */
    public function show(SslCert $sslCert): Response
    {
        return $this->render('ssl_cert/show.html.twig', [
            'ssl_cert' => $sslCert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ssl_cert_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslCert $sslCert): Response
    {
        $form = $this->createForm(SslCertType::class, $sslCert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ssl_cert_index');
        }

        return $this->render('ssl_cert/edit.html.twig', [
            'ssl_cert' => $sslCert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_cert_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslCert $sslCert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sslCert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sslCert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssl_cert_index');
    }
}
