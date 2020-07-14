<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table(name="domains", indexes={@ORM\Index(name="domain_idx", columns={"domain"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Domain
{

    const STATUS_EXPIRED = 0;

    const STATUS_ACTIVE = 1;

    const STATUS_PENDING_TRANSFER = 2;

    const STATUS_PENDING_RENEWAL = 3;

    const STATUS_PENDING_OTHER = 4;

    const STATUS_PENDING_REGISTRATION = 5;

    const STATUS_SOLD = 10;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="domains")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     *
     */
    private $owner;

    /**
     *
     * @var Registrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="domains")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar;

    /**
     *
     * @var RegistrarAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount", inversedBy="domains")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private $tld;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=false)
     */
    private $expiryDate;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="domains")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="id")
     *
     * @var Category
     */
    private $category;

    /**
     *
     * @var Fee
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Fee")
     * @ORM\JoinColumn(name="fee_id", referencedColumnName="id")
     */
    private $fee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="total_cost", type="float", nullable=false)
     */
    private $totalCost;

    /**
     *
     * @var Dns
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Dns", inversedBy="domains")
     * @ORM\JoinColumn(name="dns_id", referencedColumnName="id")
     */
    private $dns;

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress", inversedBy="domains")
     * @ORM\JoinColumn(name="ip_id", referencedColumnName="id")
     */
    private $ip;

    /**
     *
     * @var Hosting
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting", inversedBy="domains")
     * @ORM\JoinColumn(name="hosting_id", referencedColumnName="id")
     */
    private $hostingProvider;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="function", type="string", length=255, nullable=true)
     */
    private $function;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

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
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->status = '1';
        $this->totalCost = 0;
        $this->feeFixed = false;
        $this->autorenew = false;
        $this->privacy = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function getRegistrar(): ?Registrar
    {
        return $this->registrar;
    }

    public function getAccount(): ?RegistrarAccount
    {
        return $this->account;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function getExpiryDate(): ?\DateTime
    {
        return $this->expiryDate;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getFee(): ?Fee
    {
        return $this->fee;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function getDns(): ?Dns
    {
        return $this->dns;
    }

    public function getIp(): ?IpAddress
    {
        return $this->ip;
    }

    public function getHostingProvider(): ?Hosting
    {
        return $this->hostingProvider;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function isAutorenew(): bool
    {
        return $this->autorenew;
    }

    public function isPrivacy(): bool
    {
        return $this->privacy;
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
        return $this->creationType;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function setRegistrar(?Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function setAccount(?RegistrarAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function setTld(string $tld = null): self
    {
        if($tld === null and $this->domain !== null) {
            $tld = preg_replace("/^((.*?)\.)(.*)$/", "\\3", $this->domain);          
        }
        $this->tld = $tld;
        return $this;
    }

    public function setExpiryDate(\DateTime $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function setFee(?Fee $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function setDns(?Dns $dns): self
    {
        $this->dns = $dns;
        return $this;
    }

    public function setIp(?IpAddress $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function setHostingProvider(?Hosting $hostingProvider): self
    {
        $this->hostingProvider = $hostingProvider;
        return $this;
    }

    public function setFunction(?string $function): self
    {
        $function = $function ?? '';
        $this->function = $function;
        return $this;
    }

    public function setNotes(?string $notes): self
    {
        $notes = $notes ?? '';
        $this->notes = $notes;
        return $this;
    }

    public function setAutorenew(bool $autorenew = false): self
    {
        $this->autorenew = $autorenew;
        return $this;
    }

    public function setPrivacy(bool $privacy = false): self
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setFeeFixed(bool $feeFixed = false): self
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
        return $this;
    }

    public function setCreatedBy(User $user): self
    {
        $this->createdBy = $user;
        return $this;
    }
    
    public function __toString()
    {
        return $this->domain;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist()
    {
        $this->updated = new \DateTime();
    }
}
