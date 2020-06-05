<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SslCerts
 *
 * @ORM\Table(name="ssl_certs")
 * @ORM\Entity
 */
class SslCert
{

    const STATUS_EXPIRED = 0;

    const STATUS_ACTIVE = 1;

    const STATUS_PENDING_RENEWAL = 3;

    const STATUS_PENDING_OTHER = 4;

    const STATUS_PENDING_REGISTRATION = 5;

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
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     *
     * @var SslProvider
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslProvider")
     * @ORM\JoinColumn(name="ssl_provider_id", referencedColumnName="id")
     */
    private $sslProvider;

    /**
     *
     * @var SslAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslAccount")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\SslCertType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
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
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
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

    /**
     *
     * @var CreationType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CreationType")
     * @ORM\JoinColumn(name="creation_type_id", referencedColumnName="id")
     */
    private $creationType;

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
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->status = '1';
        $this->feeFixed = false;
        $this->insertTime = new \DateTime();
        $this->updateTime = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function getSslProvider(): SslProvider
    {
        return $this->sslProvider;
    }

    public function getAccount(): SslAccount
    {
        return $this->account;
    }

    public function getDomain(): Domain
    {
        return $this->domainId;
    }

    public function getType(): SslCertType
    {
        return $this->type;
    }

    public function getIp(): IpAddress
    {
        return $this->ip;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExpiryDate(): \DateTime
    {
        return $this->expiryDate;
    }

    public function getFee(): SslFee
    {
        return $this->fee;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isFeeFixed(): bool
    {
        return $this->feeFixed;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationTypeId;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getInsertTime(): \DateTime
    {
        return $this->insertTime;
    }

    public function getUpdateTime(): \DateTime
    {
        return $this->updateTime;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function setSslProvider(SslProvider $sslProvider): self
    {
        $this->sslProvider = $sslProvider;
        return $this;
    }

    public function setAccount(SslAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function setDomain(Domain $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function setType(SslCertType $type): self
    {
        $this->type = $type;
        return $this;
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

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setExpiryDate(\DateTime $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function setFee(SslFee $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->active = $active;
        return $this;
    }

    public function setFeeFixed(bool $feeFixed = true): self
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
        return $this;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
