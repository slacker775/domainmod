<?php

namespace App\Controller;

use App\Entity\Dns;
use App\Form\DnsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dns")
 */
class DnsController extends AbstractController
{
    /**
     * @Route("/", name="dns_index", methods={"GET"})
     */
    public function index(): Response
    {
        $dns = $this->getDoctrine()
            ->getRepository(Dns::class)
            ->findAll();

        return $this->render('dns/index.html.twig', [
            'dns' => $dns,
        ]);
    }

    /**
     * @Route("/new", name="dns_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dn = new Dns();
        $form = $this->createForm(DnsType::class, $dn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dn);
            $entityManager->flush();

            return $this->redirectToRoute('dns_index');
        }

        return $this->render('dns/new.html.twig', [
            'dn' => $dn,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/export", name="dns_export")
     */
    public function export()
    {
        return $this->redirectToRoute('dns_index');
    }

    /**
     * @Route("/{id}", name="dns_show", methods={"GET"})
     */
    public function show(Dns $dn): Response
    {
        return $this->render('dns/show.html.twig', [
            'dn' => $dn,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dns_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dns $dn): Response
    {
        $form = $this->createForm(DnsType::class, $dn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dns_index');
        }

        return $this->render('dns/edit.html.twig', [
            'dn' => $dn,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dns_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dns $dn): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dn->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dn);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dns_index');
    }
}
