<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Entity\RegistrarAccount;
use App\Form\RegistrarAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreationTypeRepository;
use App\Entity\Registrar;
use App\Entity\Owner;

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
    public function index(Request $request): Response
    {
        $filters = [];

        $registrarId = $request->query->getInt('registrar');
        if ($registrarId != 0) {
            $filters['registrar'] = $this->getDoctrine()
                ->getRepository(Registrar::class)
                ->find($registrarId);
        }
        $accountId = $request->query->getInt('account');
        if ($accountId != 0) {
            $filters['account'] = $this->getDoctrine()
                ->getRepository(RegistrarAccount::class)
                ->find($accountId);
        }
        $ownerId = $request->query->getInt('owner');
        if ($ownerId != 0) {
            $filters['owner'] = $this->getDoctrine()
                ->getRepository(Owner::class)
                ->find($ownerId);
        }
        $registrarAccounts = $this->getDoctrine()
            ->getRepository(RegistrarAccount::class)
            ->findBy($filters);

        return $this->render('registrar_account/index.html.twig', [
            'registrar_accounts' => $registrarAccounts,
            'defaultRegistrarAccount' => null
        ]);
    }

    /**
     *
     * @Route("/new", name="registrar_account_new", methods={"GET","POST"})
     */
    public function new(Request $request, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $registrarAccount = new RegistrarAccount();
        $form = $this->createForm(RegistrarAccountType::class, $registrarAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registrarAccount->setCreationType($creationTypeRepository->findByName('Manual'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registrarAccount);
            $entityManager->flush();

            $this->addFlash('success', sprintf('Registrar Account %s Added', $registrarAccount->getUsername()));
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
     * @Route("/{id}/edit", name="registrar_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RegistrarAccount $registrarAccount): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(RegistrarAccountType::class, $registrarAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            $this->addFlash('success', sprintf('Registrar Account %s Updated', $registrarAccount->getUsername()));
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $registrarAccount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registrarAccount);
            $entityManager->flush();
            $this->addFlash('success', sprintf('Registrar Account %s Deleted', $registrarAccount->getUsername()));
        }

        return $this->redirectToRoute('registrar_account_index');
    }
}
