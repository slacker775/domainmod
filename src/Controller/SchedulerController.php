<?php
namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SchedulerRepository;
use App\Entity\Scheduler;

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
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('scheduler/index.html.twig', [
            'controller_name' => 'SchedulerController',
            'schedules' => $this->repository->findBy([], [
                'sortOrder' => 'ASC'
            ])
        ]);
    }

    /**
     *
     * @Route("/{id}/disable", name="scheduler_disable")
     */
    public function disable(Scheduler $schedule)
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
    public function enable(Scheduler $schedule)
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
    public function run(Scheduler $schedule)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->redirectToRoute('scheduler_index');
    }

    /**
     * @Route("/{id}/update", name="scheduler_update")
     */
    public function update(Scheduler $schedule): Response
    {
        return $this->redirectToRoute('scheduler_index');
    }

}
