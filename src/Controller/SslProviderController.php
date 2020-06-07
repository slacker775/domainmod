<?php

namespace App\Controller;

use App\Entity\SslProvider;
use App\Form\SslProviderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ssl/provider")
 */
class SslProviderController extends AbstractController
{
    /**
     * @Route("/", name="ssl_provider_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslProviders = $this->getDoctrine()
            ->getRepository(SslProvider::class)
            ->findAll();

        return $this->render('ssl_provider/index.html.twig', [
            'ssl_providers' => $sslProviders,
        ]);
    }

    /**
     * @Route("/new", name="ssl_provider_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sslProvider = new SslProvider();
        $form = $this->createForm(SslProviderType::class, $sslProvider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sslProvider);
            $entityManager->flush();

            return $this->redirectToRoute('ssl_provider_index');
        }

        return $this->render('ssl_provider/new.html.twig', [
            'ssl_provider' => $sslProvider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_provider_show", methods={"GET"})
     */
    public function show(SslProvider $sslProvider): Response
    {
        return $this->render('ssl_provider/show.html.twig', [
            'ssl_provider' => $sslProvider,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ssl_provider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslProvider $sslProvider): Response
    {
        $form = $this->createForm(SslProviderType::class, $sslProvider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ssl_provider_index');
        }

        return $this->render('ssl_provider/edit.html.twig', [
            'ssl_provider' => $sslProvider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_provider_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslProvider $sslProvider): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sslProvider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sslProvider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssl_provider_index');
    }
}
