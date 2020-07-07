<?php
namespace App\Service\ApiRegistrar;

interface ApiRegistrarInterface
{
    public function listDomains() : array;
    
    public function getDomain(string $domain): array;
    
    public function setCredentials(array $credentials): void;
}