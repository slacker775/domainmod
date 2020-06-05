<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QueueController extends AbstractController
{
    /**
     * @Route("/queue", name="queue")
     */
    public function index()
    {
        return $this->render('queue/index.html.twig', [
            'controller_name' => 'QueueController',
            'domainsInQueue' => false,
            'domainsInListQueue' => false,
        ]);
    }
}
