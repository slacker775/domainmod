<?php
namespace App\Controller;

use App\Entity\SslProvider;
use App\Form\SslProviderType;
use App\Repository\SslProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/ssl/provider")
 */
class SslProviderController extends AbstractController
{
    /**
     *
     * @Route("/", name="ssl_provider_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sslProviders = $this->getDoctrine()
            ->getRepository(SslProvider::class)
            ->findAll();

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
    public function new(Request $request, SslProviderRepository $repository): Response
    {
        $sslProvider = new SslProvider();
        $form = $this->createForm(SslProviderType::class, $sslProvider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($sslProvider);

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
     * @Route("/{id}", name="ssl_provider_show", methods={"GET"})
     */
    public function show(SslProvider $sslProvider): Response
    {
        return $this->render('ssl_provider/show.html.twig', [
            'ssl_provider' => $sslProvider
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="ssl_provider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SslProvider $sslProvider): Response
    {
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
    public function delete(Request $request, SslProvider $sslProvider, SslProviderRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sslProvider->getId(), $request->request->get('_token'))) {
            $repository->remove($sslProvider);
            $this->addFlash('success', sprintf('SSL Provider %s Deleted', $sslProvider->getName()));
        }

        return $this->redirectToRoute('ssl_provider_index');
    }
}
