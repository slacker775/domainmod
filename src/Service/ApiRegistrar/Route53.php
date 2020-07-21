<?php
namespace App\Service\ApiRegistrar;

use Aws\Route53Domains\Route53DomainsClient;
use Aws\Credentials\Credentials;
use Aws\Credentials\CredentialProvider;

class Route53 implements ApiRegistrarInterface
{

    public const API_VERSION = '2014-05-15';

    private ?string $region;

    private ?string $apiKey;

    private ?string $apiSecret;

    private ?string $apiToken;

    private ?Route53DomainsClient $apiClient;

    public function __construct()
    {
        $this->apiClient = null;
        $this->apiKey = null;
        $this->apiSecret = null;
        $this->apiToken = null;
        $this->region = null;
    }

    private function getInstance(): Route53DomainsClient
    {
        if ($this->apiClient === null) {
            if ($this->apiKey === null || $this->apiSecret === null) {
                throw new \Exception('Route53 service requires region, apiKey and apiSecret to be set!');
            }

            $creds = new Credentials($this->apiKey, $this->apiSecret, $this->apiToken);
            $this->apiClient = Route53DomainsClient::factory([
                'credentials' => CredentialProvider::fromCredentials($creds),
                'version' => self::API_VERSION,
                'region' => $this->region
            ]);
        }
        return $this->apiClient;
    }

    public function getDomain(string $domain): array
    {
        $result = $this->getInstance()->getDomainDetail([
            'DomainName' => $domain
        ]);

        $nameServers = [];
        $servers = $result->get('Nameservers');
        foreach($servers as $ns) {
            $nameServers[] = $ns['Name'];
        }
        return [
            'expirationDate' => $result->get('ExpirationDate'),
            'dnsServers' => $nameServers,
            'privacyStatus' => $result->get('RegistrantPrivacy'),
            'autorenewStatus' => $result->get('AutoRenew'),
            'domainStatus' => null,
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\ApiRegistrar\ApiRegistrarInterface::listDomains()
     */
    public function listDomains(): array
    {
        $client = $this->getInstance();
        $result = $client->listDomains();
        $domains = [];
        foreach($result->get('Domains') as $d) {
            $domains[] = $d['DomainName'];
        }
        return $domains;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Service\ApiRegistrar\ApiRegistrarInterface::setCredentials()
     */
    public function setCredentials(array $credentials): void
    {
        $this->apiKey = isset($credentials['apiKey']) ? $credentials['apiKey'] : null;
        $this->apiSecret = isset($credentials['apiSecret']) ? $credentials['apiSecret'] : null;
        $this->apiToken = isset($credentials['apiToken']) ? $credentials['apiToken'] : null;
        $this->region = isset($credentials['apiName']) ? $credentials['apiName'] : null;
    }
}