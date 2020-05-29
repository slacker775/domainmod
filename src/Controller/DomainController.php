<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DomainController extends AbstractController
{
    /**
     * @Route("/domain", name="domain")
     */
    public function index()
    {
        return $this->render('domain/index.html.twig', [
            'controller_name' => 'DomainController',
        ]);
    }
}
