<?php
declare(strict_types = 1);
namespace App\Service\ApiRegistrar;

use GoDaddy\Domain\ClientFactory;
use GoDaddy\Domain\Api\Client;

class GoDaddy implements ApiRegistrarInterface
{

    private string $apiKey;

    private string $apiSecret;

    private $apiClient;
    
    public function __construct()
    {
        $this->apiClient = null;
    }

    private function getInstance(): Client
    {
        if($this->apiClient === null) {
            $this->apiClient = ClientFactory::create($this->apiKey, $this->apiSecret);
        }
        return $this->apiClient;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\ApiRegistrar\ApiRegistrarInterface::getDomain()
     */
    public function getDomain(string $domain): array
    {
        $result = $this->getInstance()->get($domain);
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\ApiRegistrar\ApiRegistrarInterface::listDomains()
     */
    public function listDomains(): array
    {
        $data = $this->getInstance()->listDomains();
        $result = [];
        foreach($data as $domain) {
            $result[] = $domain->getDomain();
        }
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\ApiRegistrar\ApiRegistrarInterface::setCredentials()
     */
    public function setCredentials(array $credentials): void
    {
        $this->apiKey = $credentials['apiKey'];
        $this->apiSecret = $credentials['apiSecret'];
    }
}