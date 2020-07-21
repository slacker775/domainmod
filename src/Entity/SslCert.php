<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * SslCerts
 *
 * @ORM\Entity
 */
class SslCert
{

    const STATUS_EXPIRED = 0;

    const STATUS_ACTIVE = 1;

    const STATUS_PENDING_RENEWAL = 3;

    const STATUS_PENDING_OTHER = 4;

    const STATUS_PENDING_REGISTRATION = 5;

    use EntityIdTrait;

    /**
     *
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="sslCerts")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     *
     * @var SslProvider
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslProvider", inversedBy="certs")
     * @ORM\JoinColumn(name="ssl_provider_id", referencedColumnName="id")
     */
    private $sslProvider;

    /**
     *
     * @var SslAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslAccount", inversedBy="certs")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

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
     * @var SslCertType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslCertType", inversedBy="sslCerts")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress", inversedBy="sslCerts")
     * @ORM\JoinColumn(name="ip_id", referencedColumnName="id")
     */
    private $ip;

    /**
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="sslCerts")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="id")
     */
    private $category;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=false)
     */
    private $expiryDate;

    /**
     *
     * @var SslFee
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslFee")
     * @ORM\JoinColumn(name="fee_id", referencedColumnName="id")
     */
    private $fee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="total_cost", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalCost;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=2, nullable=false, options={"default"="1"})
     */
    private $status;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="fee_fixed", type="boolean", nullable=false)
     */
    private $feeFixed;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->status = '1';
        $this->total_cost = 0.0;
        $this->feeFixed = false;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getSslProvider(): ?SslProvider
    {
        return $this->sslProvider;
    }

    public function setSslProvider(SslProvider $sslProvider): self
    {
        $this->sslProvider = $sslProvider;
        return $this;
    }

    public function getAccount(): ?SslAccount
    {
        return $this->account;
    }

    public function setAccount(SslAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(Domain $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function getType(): ?SslCertType
    {
        return $this->type;
    }

    public function setType(SslCertType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getIp(): ?IpAddress
    {
        return $this->ip;
    }

    /**
     *
     * @param number $ipId
     */
    public function setIp(IpAddress $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(\DateTime $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function getFee(): ?SslFee
    {
        return $this->fee;
    }

    public function setFee(?SslFee $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function isFeeFixed(): bool
    {
        return $this->feeFixed;
    }

    public function setFeeFixed(bool $feeFixed = true): self
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }


}
