<?php

namespace App\Controller;

use App\Entity\SslAccount;
use App\Form\SslAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ssl/account")
 */
class SslAccountController extends AbstractController
{
    /**
     * @Route("/", name="ssl_account_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslAccounts = $this->getDoctrine()
            ->getRepository(SslAccount::class)
            ->findAll();

        return $this->render('ssl_account/index.html.twig', [
            'ssl_accounts' => $sslAccounts,
        ]);
    }

    /**
     * @Route("/new", name="ssl_account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sslAccount = new SslAccount();
        $form = $this->createForm(SslAccountType::class, $sslAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sslAccount);
            $entityManager->flush();

            return $this->redirectToRoute('ssl_account_index');
        }

        return $this->render('ssl_account/new.html.twig', [
            'ssl_account' => $sslAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_account_show", methods={"GET"})
     */
    public function show(SslAccount $sslAccount): Response
    {
        return $this->render('ssl_account/show.html.twig', [
            'ssl_account' => $sslAccount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ssl_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslAccount $sslAccount): Response
    {
        $form = $this->createForm(SslAccountType::class, $sslAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ssl_account_index');
        }

        return $this->render('ssl_account/edit.html.twig', [
            'ssl_account' => $sslAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ssl_account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslAccount $sslAccount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sslAccount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sslAccount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ssl_account_index');
    }
}
