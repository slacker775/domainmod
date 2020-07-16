<?php
namespace App\Controller;

use App\Entity\SslProvider;
use App\Form\SslProviderType;
use App\Repository\SslProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreationTypeRepository;

/**
 *
 * @Route("/ssl/provider")
 */
class SslProviderController extends AbstractController
{

    private SslProviderRepository $repository;

    public function __construct(SslProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @Route("/", name="ssl_provider_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslProviders = $this->repository->findAll();

        return $this->render('ssl_provider/index.html.twig', [
            'ssl_providers' => $sslProviders
        ]);
    }

    /**
     *
     * @Route("/export", name="ssl_provider_export")
     */
    public function export()
    {
        return $this->redirectToRoute('ssl_provider_index');
    }

    /**
     *
     * @Route("/new", name="ssl_provider_new", methods={"GET","POST"})
     */
    public function new(Request $request, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $sslProvider = new SslProvider();
        $form = $this->createForm(SslProviderType::class, $sslProvider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sslProvider->setCreationType($creationTypeRepository->findByName('Manual'));            
            $this->repository->save($sslProvider);

            $this->addFlash('success', sprintf('SSL Provider %s Added', $sslProvider->getName()));
            return $this->redirectToRoute('ssl_provider_index');
        }

        return $this->render('ssl_provider/new.html.twig', [
            'ssl_provider' => $sslProvider,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="ssl_provider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslProvider $sslProvider): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(SslProviderType::class, $sslProvider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', sprintf('SSL Provider %s Update', $sslProvider->getName()));

            return $this->redirectToRoute('ssl_provider_index');
        }

        return $this->render('ssl_provider/edit.html.twig', [
            'ssl_provider' => $sslProvider,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/fees", name="ssl_provider_fees", methods={"GET","POST"})
     */
    public function fees(Request $request, SslProvider $sslProvider): Response
    {
        return $this->redirectToRoute('ssl_provider_index');
    }

    /**
     *
     * @Route("/{id}", name="ssl_provider_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SslProvider $sslProvider): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $sslProvider->getId(), $request->request->get('_token'))) {
            $this->repository->remove($sslProvider);
            $this->addFlash('success', sprintf('SSL Provider %s Deleted', $sslProvider->getName()));
        }

        return $this->redirectToRoute('ssl_provider_index');
    }
}
