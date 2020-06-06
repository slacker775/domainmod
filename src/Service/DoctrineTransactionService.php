<?php
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTransactionService implements TransactionServiceInterface
{

    /**
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\TransactionServiceInterface::commit()
     */
    public function commit(): void
    {
        $this->entityManager->flush();
        if ($this->entityManager->getConnection()->isTransactionActive() === true) {
            $this->entityManager->getConnection()->commit();
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\TransactionServiceInterface::rollback()
     */
    public function rollback(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive() === true) {
            $this->entityManager->getConnection()->rollBack();
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\TransactionServiceInterface::start()
     */
    public function start(): void
    {
        $this->entityManager->getConnection()->beginTransaction();
    }
}