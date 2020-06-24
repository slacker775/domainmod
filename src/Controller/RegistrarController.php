<?php
namespace App\Controller;

use App\Entity\Registrar;
use App\Form\RegistrarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RegistrarRepository;
use App\Repository\SettingRepository;

/**
 *
 * @Route("/assets/registrar")
 */
class RegistrarController extends AbstractController
{

    /**
     *
     * @Route("/", name="registrar_index", methods={"GET"})
     */
    public function index(RegistrarRepository $repository, SettingRepository $settingRepository): Response
    {
        $registrars = $repository->findAll();
        $settings = $settingRepository->findOneBy([]);

        return $this->render('registrar/index.html.twig', [
            'registrars' => $registrars,
            'displayInactiveAssets' => true,
            'defaultRegistrar' => $settings->getDefaultRegistrar()
        ]);
    }

    /**
     *
     * @Route("/new", name="registrar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $registrar = new Registrar();
        $form = $this->createForm(RegistrarType::class, $registrar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registrar);
            $entityManager->flush();

            return $this->redirectToRoute('registrar_index');
        }

        return $this->render('registrar/new.html.twig', [
            'registrar' => $registrar,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/export", name="registrar_export")
     */
    public function export()
    {
        return $this->redirectToRoute('registrar_index');
    }

    /**
     *
     * @Route("/{id}/edit", name="registrar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Registrar $registrar): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(RegistrarType::class, $registrar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('registrar_index');
        }

        return $this->render('registrar/edit.html.twig', [
            'registrar' => $registrar,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="registrar_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Registrar $registrar): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $registrar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registrar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('registrar_index');
    }

    /**
     *
     * @Route("/missing/fees", name="registrar_missing_fees", methods={"GET"})
     */
    public function missingFees(RegistrarRepository $repository)
    {
        return $this->render('registrar/missing-fees.html.twig', [
            'fees' => $repository->getMissingFees()
        ]);
    }
}
