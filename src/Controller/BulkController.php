<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bulk")
 *
 */
class BulkController extends AbstractController
{
    /**
     * @Route("/", name="bulk_index")
     */
    public function index()
    {
        return $this->render('bulk/index.html.twig', [
            'controller_name' => 'BulkController',
        ]);
    }
}
