<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UserDefaultsType;
use App\Repository\SettingRepository;
use App\Form\UserDisplayType;
use App\Service\SettingsResolver;

/**
 *
 * @Route("/settings")
 *
 */
class SettingsController extends AbstractController
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
     * @Route("/", name="settings_index")
     */
    public function index()
    {
        return $this->render('settings/index.html.twig');
    }

    /**
     *
     * @Route("/defaults", name="settings_defaults")
     */
    public function defaults(Request $request): Response
    {
        $form = $this->createForm(UserDefaultsType::class, $this->getUser()
            ->getSettings());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->container->get('session')->set('settings', $this->resolver->resolveSettings($this->getUser()));
            $this->addFlash('success', 'Your Defaults were updated');
        }

        return $this->render('settings/defaults.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/display", name="settings_display")
     */
    public function display(Request $request): Response
    {
        $form = $this->createForm(UserDisplayType::class, $this->getUser()
            ->getSettings());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->container->get('session')->set('settings', $this->resolver->resolveSettings($this->getUser()));            
            $this->addFlash('success', 'Your display preferences were updated');
        }
        return $this->render('settings/display.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/password", name="settings_password")
     */
    public function password()
    {
        return $this->render('settings/password.html.twig', [
            'controller_name' => 'SettingsController'
        ]);
    }

    /**
     *
     * @Route("/profile", name="settings_profile")
     */
    public function profile()
    {
        return $this->render('settings/profile.html.twig', [
            'controller_name' => 'SettingsController'
        ]);
    }
}
