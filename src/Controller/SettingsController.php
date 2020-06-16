<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/settings")
 *
 */
class SettingsController extends AbstractController
{

    /**
     *
     * @Route("/defaults", name="settings_defaults")
     */
    public function defaults()
    {
        return $this->render('settings/defaults.html.twig', [
            'controller_name' => 'SettingsController'
        ]);
    }

    /**
     *
     * @Route("/display", name="settings_display")
     */
    public function display()
    {
        return $this->render('settings/display.html.twig', [
            'controller_name' => 'SettingsController'
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
