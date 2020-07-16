<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SystemDefaultsType;
use App\Repository\SettingRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SystemSettingsType;
use App\Service\SettingsResolver;

/**
 *
 * @Route("/admin")
 * @author dhollis
 *        
 */
class AdminController extends AbstractController
{

    private SettingRepository $repository;

    private SettingsResolver $resolver;

    public function __construct(SettingRepository $repository, SettingsResolver $resolver)
    {
        $this->repository = $repository;
        $this->resolver = $resolver;
    }

    /**
     *
     * @Route("/", name="admin_index")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     *
     * @Route("/defaults", name="admin_defaults")
     */
    public function defaults(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $setting = $this->repository->findOneBy([]);
        $form = $this->createForm(SystemDefaultsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($setting);
            $this->container->get('session')->set('settings', $this->resolver->resolveSettings($this->getUser()));
            $this->addFlash('success', 'The System Defaults were updated');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/defaults.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/settings", name="admin_settings")
     */
    public function settings(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $setting = $this->repository->getSettings();
        $form = $this->createForm(SystemSettingsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($setting);
            $this->container->get('session')->set('settings', $this->resolver->resolveSettings($this->getUser()));
            $this->addFlash('success', 'The System Settings were updated');
            $request->getSession()->set('settings', $setting);
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
