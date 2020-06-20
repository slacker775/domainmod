<?php

namespace App\Controller;

use App\Entity\Dns;
use App\Form\DnsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreationTypeRepository;

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
    public function new(Request $request, CreationTypeRepository $creationTypeRespository): Response
    {
        $dns = new Dns();
        $form = $this->createForm(DnsType::class, $dns);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dns->setCreationType($creationTypeRespository->findByName('Manual'))->setCreatedBy($this->getUser());
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dns);
            $entityManager->flush();

            $this->addFlash('success', sprintf('DNS Profile %s Added', $dns->getName()));            
            return $this->redirectToRoute('dns_index');
        }

        return $this->render('dns/new.html.twig', [
            'dn' => $dns,
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

            $this->addFlash('success', sprintf('DNS Profile %s Updated', $dn->getName()));
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
            $this->addFlash('success', sprintf('DNS Profile %s Deleted', $dn->getName()));           
        }

        return $this->redirectToRoute('dns_index');
    }
}
