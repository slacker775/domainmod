<?php
namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreationTypeRepository;

/**
 *
 * @Route("/owner")
 */
class OwnerController extends AbstractController
{

    /**
     *
     * @Route("/", name="owner_index", methods={"GET"})
     */
    public function index(): Response
    {
        $owners = $this->getDoctrine()
            ->getRepository(Owner::class)
            ->findAll();

        return $this->render('owner/index.html.twig', [
            'owners' => $owners
        ]);
    }

    /**
     *
     * @Route("/new", name="owner_new", methods={"GET","POST"})
     */
    public function new(Request $request, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $owner = new Owner();
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $owner->setCreationType($creationTypeRepository->findByName('Manual'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($owner);
            $entityManager->flush();

            $this->addFlash('success', sprintf('Owner %s Added', $owner->getName()));
            return $this->redirectToRoute('owner_index');
        }

        return $this->render('owner/new.html.twig', [
            'owner' => $owner,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/export", name="owner_export")
     */
    public function export()
    {
        return $this->redirectToRoute('owner_index');
    }

    /**
     *
     * @Route("/{id}/edit", name="owner_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Owner $owner): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('owner_index');
        }

        return $this->render('owner/edit.html.twig', [
            'owner' => $owner,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="owner_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Owner $owner): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $owner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($owner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('owner_index');
    }
}
