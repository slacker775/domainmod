<?php
namespace App\Controller;

use App\Entity\SslAccount;
use App\Form\SslAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SslAccountRepository;

/**
 *
 * @Route("/ssl/account")
 */
class SslAccountController extends AbstractController
{

    private SslAccountRepository $repository;

    public function __construct(SslAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @Route("/", name="ssl_account_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslAccounts = $this->repository->findAll();

        return $this->render('ssl_account/index.html.twig', [
            'ssl_accounts' => $sslAccounts
        ]);
    }

    /**
     *
     * @Route("/new", name="ssl_account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $sslAccount = new SslAccount();
        $form = $this->createForm(SslAccountType::class, $sslAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($sslAccount);

            $this->addFlash('success', sprintf('SSL Account %s Added', $sslAccount->getUsername()));

            return $this->redirectToRoute('ssl_account_index');
        }

        return $this->render('ssl_account/new.html.twig', [
            'ssl_account' => $sslAccount,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="ssl_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslAccount $sslAccount): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(SslAccountType::class, $sslAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', sprintf('SSL Account %s Updated', $sslAccount->getUsername()));

            return $this->redirectToRoute('ssl_account_index');
        }

        return $this->render('ssl_account/edit.html.twig', [
            'ssl_account' => $sslAccount,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="ssl_account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslAccount $sslAccount): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $sslAccount->getId(), $request->request->get('_token'))) {
            $this->repository->remove($sslAccount);

            $this->addFlash('success', sprintf('SSL Account %s Deleted', $sslAccount->getUsername()));
        }

        return $this->redirectToRoute('ssl_account_index');
    }
}
