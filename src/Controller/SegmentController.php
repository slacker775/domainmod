<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SegmentRepository;

/**
 * @Route("/segments")
 *
 */
class SegmentController extends AbstractController
{
    /**
     * @Route("/", name="segment")
     */
    public function index(SegmentRepository $repository)
    {
        return $this->render('segment/index.html.twig', [
            'controller_name' => 'SegmentController',
            'segments' => $repository->getAllSegments(),
        ]);
    }
    
    /**
     * @Route("/add", name="segment.add")
     */
    public function add()
    {
        return $this->render('segment/add.html.twig',[]);
    }
}
