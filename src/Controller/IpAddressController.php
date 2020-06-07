<?php

namespace App\Controller;

use App\Entity\IpAddress;
use App\Form\IpAddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ip/address")
 */
class IpAddressController extends AbstractController
{
    /**
     * @Route("/", name="ip_address_index", methods={"GET"})
     */
    public function index(): Response
    {
        $ipAddresses = $this->getDoctrine()
            ->getRepository(IpAddress::class)
            ->findAll();

        return $this->render('ip_address/index.html.twig', [
            'ip_addresses' => $ipAddresses,
        ]);
    }

    /**
     * @Route("/new", name="ip_address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ipAddress = new IpAddress();
        $form = $this->createForm(IpAddressType::class, $ipAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ipAddress);
            $entityManager->flush();

            return $this->redirectToRoute('ip_address_index');
        }

        return $this->render('ip_address/new.html.twig', [
            'ip_address' => $ipAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ip_address_show", methods={"GET"})
     */
    public function show(IpAddress $ipAddress): Response
    {
        return $this->render('ip_address/show.html.twig', [
            'ip_address' => $ipAddress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ip_address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, IpAddress $ipAddress): Response
    {
        $form = $this->createForm(IpAddressType::class, $ipAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ip_address_index');
        }

        return $this->render('ip_address/edit.html.twig', [
            'ip_address' => $ipAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ip_address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, IpAddress $ipAddress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ipAddress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ipAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ip_address_index');
    }
}
