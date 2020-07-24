<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class DomainExpired extends Event
{
    public const NAME = 'domain.expired';

    protected array $domains;

    public function __construct(array $domains)
    {
        $this->domains = $domains;
    }

    public function getDomains(): array
    {
        return $this->domains;
    }
}