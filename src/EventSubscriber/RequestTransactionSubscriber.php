<?php
declare(strict_types = 1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Service\TransactionServiceInterface;

final class RequestTransactionSubscriber implements EventSubscriberInterface
{

    /**
     *
     * @var TransactionServiceInterface
     */
    private $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                'startTransaction',
                10
            ],
            KernelEvents::RESPONSE => [
                'commitTransaction',
                10
            ],
            KernelEvents::EXCEPTION => [
                'rollbackTransaction',
                11
            ]
        ];
    }

    public function startTransaction(): void
    {
        $this->transactionService->start();
    }

    public function commitTransaction(): void
    {
        $this->transactionService->commit();
    }

    public function rollbackTransaction(): void
    {
        $this->transactionService->rollback();
    }
}