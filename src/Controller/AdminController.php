<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SystemDefaultsType;
use App\Repository\SettingRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SystemSettingsType;

/**
 *
 * @Route("/admin")
 * @author dhollis
 *        
 */
class AdminController extends AbstractController
{

    /**
     *
     * @Route("/", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     *
     * @Route("/defaults", name="admin_defaults")
     */
    public function defaults(Request $request, SettingRepository $repository)
    {
        $setting = $repository->findOneBy([]);
        $form = $this->createForm(SystemDefaultsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($setting);

            $this->addFlash('success', 'The System Defaults were updated');           
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/defaults.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings", name="admin_settings")
     */
    public function settings(Request $request, SettingRepository $repository)
    {
        $setting = $repository->findOneBy([]);
        $form = $this->createForm(SystemSettingsType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($setting);

            $this->addFlash('success', 'The System Settings were updated');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
