<?php
namespace App\Controller;

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

    /**
     *
     * @Route("/", name="scheduler_index")
     */
    public function index(SchedulerRepository $repository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('scheduler/index.html.twig', [
            'controller_name' => 'SchedulerController',
            'schedules' => $repository->findBy([], [
                'sortOrder' => 'ASC'
            ])
        ]);
    }

    /**
     *
     * @Route("/{id}/disable", name="scheduler_disable")
     */
    public function disable(SchedulerRepository $repository, Scheduler $schedule)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $schedule->setActive(false);
        $repository->save($schedule);
        return $this->redirectToRoute('scheduler_index');
    }

    /**
     *
     * @Route("/{id}/enable", name="scheduler_enable")
     */
    public function enable(SchedulerRepository $repository, Scheduler $schedule)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $schedule->setActive(true);
        $repository->save($schedule);
        return $this->redirectToRoute('scheduler_index');
    }

    /**
     *
     * @Route("/{id}/run", name="scheduler_run")
     */
    public function run(SchedulerRepository $repository, Scheduler $schedule)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->redirectToRoute('scheduler_index');
    }
}
