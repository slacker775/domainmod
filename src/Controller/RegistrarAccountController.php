<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Entity\RegistrarAccount;
use App\Form\RegistrarAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/registrar/account")
 */
class RegistrarAccountController extends AbstractController
{

    /**
     *
     * @Route("/", name="registrar_account_index", methods={"GET"})
     */
    public function index(): Response
    {
        /* FIXME - allow filtering by registrar, owner or registrar account */
        $registrarAccounts = $this->getDoctrine()
            ->getRepository(RegistrarAccount::class)
            ->findAll();

        return $this->render('registrar_account/index.html.twig', [
            'registrar_accounts' => $registrarAccounts,
            'defaultRegistrarAccount' => null
        ]);
    }

    /**
     *
     * @Route("/new", name="registrar_account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $registrarAccount = new RegistrarAccount();
        $form = $this->createForm(RegistrarAccountType::class, $registrarAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registrarAccount);
            $entityManager->flush();

            return $this->redirectToRoute('registrar_account_index');
        }

        return $this->render('registrar_account/new.html.twig', [
            'registrar_account' => $registrarAccount,
            'form' => $form->createView()
        ]);
    }
    
    /**
     *
     * @Route("/export", name="registrar_account_export")
     */
    public function export(Request $request): Response
    {
        return $this->redirectToRoute('registrar_account_index');
    }

    /**
     *
     * @Route("/{id}", name="registrar_account_show", methods={"GET"})
     */
    public function show(RegistrarAccount $registrarAccount): Response
    {
        return $this->render('registrar_account/show.html.twig', [
            'registrar_account' => $registrarAccount
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="registrar_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RegistrarAccount $registrarAccount): Response
    {
        dump($registrarAccount);
        $form = $this->createForm(RegistrarAccountType::class, $registrarAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('registrar_account_index');
        }

        return $this->render('registrar_account/edit.html.twig', [
            'registrar_account' => $registrarAccount,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="registrar_account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RegistrarAccount $registrarAccount): Response
    {
        if ($this->isCsrfTokenValid('delete' . $registrarAccount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registrarAccount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('registrar_account_index');
    }
}
