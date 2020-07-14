<?php
namespace App\Service;

interface TransactionServiceInterface
{

    public function start(): void;

    public function commit(): void;

    public function rollback(): void;
}