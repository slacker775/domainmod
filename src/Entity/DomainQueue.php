<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * DomainQueue
 *
 * @ORM\Entity
 */
class DomainQueue
{

    use EntityIdTrait;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     */
    private ApiRegistrar $apiRegistrar;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Domain", cascade={"persist"})
     */
    private Domain $domain;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     */
    private Owner $owner;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar")
     */
    private Registrar $registrar;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount")
     */
    private RegistrarAccount $account;

    /**
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private string $domainName;

    /**
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private string $tld;

    /**
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=true)
     */
    private \DateTimeInterface $expiryDate;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private Category $category;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Dns")
     */
    private Dns $dns;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     */
    private IpAddress $ip;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting")
     */
    private Hosting $hosting;

    /**
     *
     * @ORM\Column(name="autorenew", type="boolean", nullable=false)
     */
    private bool $autorenew;

    /**
     *
     * @ORM\Column(name="privacy", type="boolean", nullable=false)
     */
    private bool $privacy;

    /**
     *
     * @ORM\Column(name="processing", type="boolean", nullable=false)
     */
    private bool $processing;

    /**
     *
     * @ORM\Column(name="ready_to_import", type="boolean", nullable=false)
     */
    private bool $readyToImport;

    /**
     *
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private bool $finished;

    /**
     *
     * @ORM\Column(name="already_in_domains", type="boolean", nullable=false)
     */
    private bool $alreadyInDomains;

    /**
     *
     * @ORM\Column(name="already_in_queue", type="boolean", nullable=false)
     */
    private bool $alreadyInQueue;

    /**
     *
     * @ORM\Column(name="invalid_domain", type="boolean", nullable=false)
     */
    private bool $invalidDomain;

    /**
     *
     * @ORM\Column(name="copied_to_history", type="boolean", nullable=false)
     */
    private bool $copiedToHistory;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->autorenew = false;
        $this->privacy = false;
        $this->processing = false;
        $this->readyToImport = false;
        $this->finished = false;
        $this->alreadyInDomains = false;
        $this->alreadyInQueue = false;
        $this->invalidDomain = false;
        $this->copiedToHistory = false;
        $this->expiryDate = new \DateTime('1/1/1970');
    }

    public function getApiRegistrar(): ApiRegistrar
    {
        return $this->apiRegistrar;
    }

    public function setApiRegistrar(ApiRegistrar $apiRegistrar): self
    {
        $this->apiRegistrar = $apiRegistrar;
        return $this;
    }

    public function getDomain(): Domain
    {
        return $this->domain;
    }

    public function setDomain(Domain $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function getAccount(): RegistrarAccount
    {
        return $this->account;
    }

    public function setAccount(RegistrarAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;
        return $this;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function setTld(string $tld): self
    {
        $this->tld = $tld;
        return $this;
    }

    public function getExpiryDate(): \DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getDns(): Dns
    {
        return $this->dns;
    }

    public function setDns(Dns $dns): self
    {
        $this->dns = $dns;
        return $this;
    }

    public function getIpAddress(): IpAddress
    {
        return $this->ip;
    }

    public function getHosting(): Hosting
    {
        return $this->hosting;
    }

    public function setHosting(Hosting $hosting): self
    {
        $this->hosting = $hosting;
        return $this;
    }

    public function isAutorenew(): bool
    {
        return $this->autorenew;
    }

    public function setAutorenew(bool $autorenew = true): self
    {
        $this->autorenew = $autorenew;
        return $this;
    }

    public function isPrivacy(): bool
    {
        return $this->privacy;
    }

    public function setPrivacy(bool $privacy = true): self
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function isProcessing(): bool
    {
        return $this->processing;
    }

    public function setProcessing(bool $processing = true): self
    {
        $this->processing = $processing;
        return $this;
    }

    public function isReadyToImport(): bool
    {
        return $this->readyToImport;
    }

    public function setReadyToImport(bool $readyToImport = true): self
    {
        $this->readyToImport = $readyToImport;
        return $this;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished = true): self
    {
        $this->finished = $finished;
        return $this;
    }

    public function isAlreadyInDomains(): bool
    {
        return $this->alreadyInDomains;
    }

    public function setAlreadyInDomains(bool $alreadyInDomains = true): self
    {
        $this->alreadyInDomains = $alreadyInDomains;
        return $this;
    }

    public function isAlreadyInQueue(): bool
    {
        return $this->alreadyInQueue;
    }

    public function setAlreadyInQueue(bool $alreadyInQueue = true): self
    {
        $this->alreadyInQueue = $alreadyInQueue;
        return $this;
    }

    public function isInvalidDomain(): bool
    {
        return $this->invalidDomain;
    }

    public function setInvalidDomain(bool $invalidDomain = true): self
    {
        $this->invalidDomain = $invalidDomain;
        return $this;
    }

    public function isCopiedToHistory(): bool
    {
        return $this->copiedToHistory;
    }

    public function setCopiedToHistory(bool $copiedToHistory = true): self
    {
        $this->copiedToHistory = $copiedToHistory;
        return $this;
    }

    public function setIp(IpAddress $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

}
