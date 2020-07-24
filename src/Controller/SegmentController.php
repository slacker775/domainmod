<?php

namespace App\Controller;

use App\Entity\Segment;
use App\Entity\SegmentData;
use App\Form\SegmentType;
use App\Repository\SegmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/segment")
 */
class SegmentController extends AbstractController
{
    private SegmentRepository $repository;

    public function __construct(SegmentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="segment_index", methods={"GET"})
     */
    public function index(): Response
    {
        $segments = $this->getDoctrine()
            ->getRepository(Segment::class)
            ->findAll();

        return $this->render('segment/index.html.twig', [
            'segments' => $segments,
        ]);
    }

    /**
     * @Route("/new", name="segment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $segment = new Segment();
        $form = $this->createForm(SegmentType::class, $segment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $segment = $this->processSegmentData($segment);
            $this->repository->save($segment);

            return $this->redirectToRoute('segment_index');
        }

        return $this->render('segment/new.html.twig', [
            'segment' => $segment,
            'form' => $form->createView(),
        ]);
    }

    private function processSegmentData(Segment $segment): Segment
    {
        $invalidDomains = [];
        $domains = [];
        $data = $this->cleanAndSplitDomains($segment->getSegment());
        foreach($data as $domain) {
            if(filter_var($domain, FILTER_VALIDATE_DOMAIN) == false) {
                $invalidDomains[] = $domain;
            } else {
                $domains[] = $domain;
                $data = SegmentData::create($domain);
                $segment->addSegmentData($data);
            }
        }
        $segment->setNumberOfDomains(count($segment->getSegmentData()));
        return $segment;
    }

    private function cleanAndSplitDomains(string $raw_domain_list): array
    {
        $clean_domain_list = $this->stripSpacing($raw_domain_list);
        $domain_list = explode("\r\n", $clean_domain_list);
        $new_domain_list = array();
        foreach ($domain_list as $value) {
            $new_domain_list[] = filter_var($this->stripSpacing($value), FILTER_VALIDATE_DOMAIN);
        }
        return array_unique($new_domain_list);
    }

    private function stripSpacing(string $input): string
    {
        return trim(preg_replace("/^\n+|^[\t\s]*\n+/m", "", $input));
    }

    /**
     * @Route("/export", name="segment_export")
     */
    public function export(Request $request): Response
    {
        return $this->redirectToRoute('segment_index');
    }

    /**
     * @Route("/{id}", name="segment_show", methods={"GET"})
     */
    public function show(Segment $segment): Response
    {
        return $this->render('segment/show.html.twig', [
            'segment' => $segment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="segment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Segment $segment): Response
    {
        $form = $this->createForm(SegmentType::class, $segment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $segment = $this->processSegmentData($segment);
            $this->repository->save($segment);

            return $this->redirectToRoute('segment_index');
        }

        return $this->render('segment/edit.html.twig', [
            'segment' => $segment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="segment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Segment $segment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $segment->getId(), $request->request->get('_token'))) {
            $this->repository->remove($segment);
        }

        return $this->redirectToRoute('segment_index');
    }
}
