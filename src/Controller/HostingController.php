<?php
namespace App\Controller;

use App\Entity\Hosting;
use App\Form\HostingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreationTypeRepository;
use App\Repository\HostingRepository;

/**
 *
 * @Route("/hosting")
 */
class HostingController extends AbstractController
{

    private HostingRepository $repository;

    public function __construct(HostingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @Route("/", name="hosting_index", methods={"GET"})
     */
    public function index(): Response
    {
        $hostings = $this->repository->findAll();

        return $this->render('hosting/index.html.twig', [
            'hostings' => $hostings
        ]);
    }

    /**
     *
     * @Route("/new", name="hosting_new", methods={"GET","POST"})
     */
    public function new(Request $request, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $hosting = new Hosting();
        $form = $this->createForm(HostingType::class, $hosting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hosting->setCreationType($creationTypeRepository->findByName('Manual'));
            $this->repository->save($hosting);

            return $this->redirectToRoute('hosting_index');
        }

        return $this->render('hosting/new.html.twig', [
            'hosting' => $hosting,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/export", name="hosting_export")
     */
    public function export()
    {
        return $this->redirectToRoute('hosting_index');
    }

    /**
     *
     * @Route("/{id}/edit", name="hosting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hosting $hosting): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(HostingType::class, $hosting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('hosting_index');
        }

        return $this->render('hosting/edit.html.twig', [
            'hosting' => $hosting,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="hosting_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hosting $hosting): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $hosting->getId(), $request->request->get('_token'))) {
            $this->repository->remove($hosting);
        }

        return $this->redirectToRoute('hosting_index');
    }
}
