<?php

namespace App\Controller;

use App\Entity\Scheduler;
use App\Repository\SchedulerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/admin/scheduler")
 *
 */
class SchedulerController extends AbstractController
{

    private SchedulerRepository $repository;

    public function __construct(SchedulerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @Route("/", name="scheduler_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render(
            'scheduler/index.html.twig', [
            'controller_name' => 'SchedulerController',
            'schedules'       => $this->repository->findBy(
                [], [
                'sortOrder' => 'ASC',
            ]
            ),
        ]
        );
    }

    /**
     *
     * @Route("/{id}/disable", name="scheduler_disable")
     */
    public function disable(Scheduler $schedule): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $schedule->setActive(false);
        $this->repository->save($schedule);
        return $this->redirectToRoute('scheduler_index');
    }

    /**
     *
     * @Route("/{id}/enable", name="scheduler_enable")
     */
    public function enable(Scheduler $schedule): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $schedule->setActive(true);
        $this->repository->save($schedule);
        return $this->redirectToRoute('scheduler_index');
    }

    /**
     *
     * @Route("/{id}/run", name="scheduler_run")
     */
    public function run(Scheduler $schedule): Response
    {
        /* FIXME - not yet implemented */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->redirectToRoute('scheduler_index');
    }

    /**
     * @Route("/{id}/update", name="scheduler_update")
     */
    public function update(Scheduler $schedule): Response
    {
        /* FIXME - not yet implemented */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->redirectToRoute('scheduler_index');
    }

}
