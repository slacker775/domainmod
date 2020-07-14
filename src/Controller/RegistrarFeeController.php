<?php
namespace App\Controller;

use App\Entity\Fee;
use App\Form\FeeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Registrar;
use App\Entity\Domain;
use App\Repository\DomainRepository;

/**
 *
 * @Route("/assets/registrar")
 */
class RegistrarFeeController extends AbstractController
{

    /**
     *
     * @Route("/{id}/fees", name="fee_index", methods={"GET"})
     */
    public function index(Registrar $registrar, DomainRepository $domainRepository): Response
    {
        $fees = $this->getDoctrine()
            ->getRepository(Fee::class)
            ->findBy([
            'registrar' => $registrar
        ]);

        return $this->render('fee/index.html.twig', [
            'fees' => $fees,
            'registrar' => $registrar,
            'domains' => $domainRepository->getTldsWithoutFeeAssignments($registrar)
        ]);
    }

    /**
     *
     * @Route("/{id}/fees/new", name="fee_new", methods={"GET","POST"})
     */
    public function new(Request $request, Registrar $registrar): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $tld = $request->query->get('tld');

        $fee = new Fee();
        $fee->setRegistrar($registrar);

        if ($tld !== null) {
            $fee->setTld($tld);
        }

        $form = $this->createForm(FeeType::class, $fee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fee);
            $entityManager->flush();

            return $this->redirectToRoute('fee_index', [
                'id' => $registrar->getId()
            ]);
        }

        return $this->render('fee/new.html.twig', [
            'fee' => $fee,
            'registrar' => $registrar,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/fees/export", name="fee_export")
     */
    public function export(Registrar $registrar): Response
    {
        return $this->redirectToRoute('fee_index');
    }

    /**
     *
     * @Route("/{id}/fees/edit", name="fee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fee $fee): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(FeeType::class, $fee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('fee_index', [
                'id' => $fee->getRegistrar()
                    ->getId()
            ]);
        }

        return $this->render('fee/edit.html.twig', [
            'fee' => $fee,
            'registrar' => $fee->getRegistrar(),
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/fees/{id}/delete", name="fee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fee $fee): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $fee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fee_index');
    }
}
