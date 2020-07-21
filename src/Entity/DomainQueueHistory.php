<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * DomainQueueHistory
 *
 * @ORM\Entity
 */
class DomainQueueHistory
{

    use EntityIdTrait;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     */
    private ApiRegistrar $apiRegistrar;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Domain")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $domainName;

    /**
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $tld;

    /**
     *
     * @ORM\Column(type="date", nullable=false)
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
    private IpAddress $ipAddress;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting")
     */
    private $hosting;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $autoRenew;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $privacy;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $alreadyInDomains;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $alreadyInQueue;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
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
        return $this->ipAddress;
    }

    public function setIpAddress(IpAddress $ipAddress): self
    {
        $this->ipAddress = $ipAddress;
        return $this;
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

    public function getAutoRenew(): bool
    {
        return $this->autoRenew;
    }

    public function setAutoRenew(bool $autoRenew): self
    {
        $this->autoRenew = $autoRenew;
        return $this;
    }

    public function getPrivacy(): bool
    {
        return $this->privacy;
    }

    public function setPrivacy(bool $privacy): self
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function getAlreadyInDomains(): bool
    {
        return $this->alreadyInDomains;
    }

    public function setAlreadyInDomains(bool $alreadyInDomains): self
    {
        $this->alreadyInDomains = $alreadyInDomains;
        return $this;
    }

    public function getAlreadyInQueue(): bool
    {
        return $this->alreadyInQueue;
    }

    public function setAlreadyInQueue(bool $alreadyInQueue): self
    {
        $this->alreadyInQueue = $alreadyInQueue;
        return $this;
    }
}
