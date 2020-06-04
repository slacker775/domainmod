<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AssetController extends AbstractController
{
    /**
     * @Route("/asset", name="asset")
     */
    public function index()
    {
        return $this->render('asset/index.html.twig', [
            'controller_name' => 'AssetController',
        ]);
    }
}
