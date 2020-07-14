<?php
declare(strict_types = 1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueue
 *
 * @ORM\Table(name="domain_queue")
 * @ORM\Entity
 */
class DomainQueue
{

    /**
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var ApiRegistrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     * @ORM\JoinColumn(name="api_registrar_id", referencedColumnName="id")
     */
    private $apiRegistrar;

    /**
     *
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Domain")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     */
    private $domain;

    /**
     *
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     *
     * @var Registrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar;

    /**
     *
     * @var RegistrarAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount")
     * @ORM\JoinColumn(name="account_id",referencedColumnName="id")
     */
    private $account;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domainName;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private $tld;

    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=true)
     */
    private $expiryDate;

    /**
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="id")
     */
    private $category;

    /**
     *
     * @var Dns
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Dns")
     * @ORM\JoinColumn(name="dns_id", referencedColumnName="id")
     */
    private $dns;

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     * @ORM\JoinColumn(name="ip_id", referencedColumnName="id")
     */
    private $ip;

    /**
     *
     * @var Hosting
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting")
     * @ORM\JoinColumn(name="hosting_id", referencedColumnName="id")
     */
    private $hosting;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="autorenew", type="boolean", nullable=false)
     */
    private $autorenew;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="privacy", type="boolean", nullable=false)
     */
    private $privacy;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="processing", type="boolean", nullable=false)
     */
    private $processing;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ready_to_import", type="boolean", nullable=false)
     */
    private $readyToImport;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private $finished;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="already_in_domains", type="boolean", nullable=false)
     */
    private $alreadyInDomains;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="already_in_queue", type="boolean", nullable=false)
     */
    private $alreadyInQueue;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="invalid_domain", type="boolean", nullable=false)
     */
    private $invalidDomain;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="copied_to_history", type="boolean", nullable=false)
     */
    private $copiedToHistory;

    /**
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    public function __construct()
    {
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
        $this->created = new \DateTIme();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getApiRegistrar(): ApiRegistrar
    {
        return $this->apiRegistrar;
    }

    public function getDomain(): Domain
    {
        return $this->domain;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }

    public function getAccount(): RegistrarAccount
    {
        return $this->account;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function getExpiryDate(): \DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getDns(): Dns
    {
        return $this->dns;
    }

    public function getIp(): IpAddress
    {
        return $this->ip;
    }

    public function getHosting(): Hosting
    {
        return $this->hosting;
    }

    public function isAutorenew(): bool
    {
        return $this->autorenew;
    }

    public function isPrivacy(): bool
    {
        return $this->privacy;
    }

    public function isProcessing(): bool
    {
        return $this->processing;
    }

    public function isReadyToImport(): bool
    {
        return $this->readyToImport;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function isAlreadyInDomains(): bool
    {
        return $this->alreadyInDomains;
    }

    public function isAlreadyInQueue(): bool
    {
        return $this->alreadyInQueue;
    }

    public function isInvalidDomain(): bool
    {
        return $this->invalidDomain;
    }

    public function isCopiedToHistory(): bool
    {
        return $this->copiedToHistory;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function setApiRegistrar(ApiRegistrar $apiRegistrar): self
    {
        $this->apiRegistrar = $apiRegistrar;
        return $this;
    }

    public function setDomain(Domain $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function setAccount(RegistrarAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;
        return $this;
    }

    public function setTld(string $tld): self
    {
        $this->tld = $tld;
        return $this;
    }

    public function setExpiryDate(\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function setDns(Dns $dns): self
    {
        $this->dns = $dns;
        return $this;
    }

    public function setIp(IpAddress $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function setHosting(Hosting $hosting): self
    {
        $this->hosting = $hosting;
        return $this;
    }

    public function setAutorenew(bool $autorenew = true): self
    {
        $this->autorenew = $autorenew;
        return $this;
    }

    public function setPrivacy(bool $privacy = true): self
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function setProcessing(bool $processing = true): self
    {
        $this->processing = $processing;
        return $this;
    }

    public function setReadyToImport(bool $readyToImport = true): self
    {
        $this->readyToImport = $readyToImport;
        return $this;
    }

    public function setFinished(bool $finished = true): self
    {
        $this->finished = $finished;
        return $this;
    }

    public function setAlreadyInDomains(bool $alreadyInDomains = true): self
    {
        $this->alreadyInDomains = $alreadyInDomains;
        return $this;
    }

    public function setAlreadyInQueue(bool $alreadyInQueue = true): self
    {
        $this->alreadyInQueue = $alreadyInQueue;
        return $this;
    }

    public function setInvalidDomain(bool $invalidDomain = true): self
    {
        $this->invalidDomain = $invalidDomain;
        return $this;
    }

    public function setCopiedToHistory(bool $copiedToHistory = true): self
    {
        $this->copiedToHistory = $copiedToHistory;
        return $this;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
