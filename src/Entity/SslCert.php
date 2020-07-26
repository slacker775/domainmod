<?php
declare(strict_types=1);

namespace App\Entity;

use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="sslCerts")
     */
    private Owner $owner;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslProvider", inversedBy="certs")
     */
    private SslProvider $sslProvider;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslAccount", inversedBy="certs")
     */
    private ?SslAccount $account;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Domain")
     */
    private ?Domain $domain;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslCertType", inversedBy="sslCerts")
     */
    private ?SslCertType $type;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress", inversedBy="sslCerts")
     */
    private ?IpAddress $ip;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="sslCerts")
     */
    private ?Category $category;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $name;

    /**
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private DateTimeInterface $expiryDate;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslFee")
     */
    private ?SslFee $fee;

    /**
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private float $totalCost;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private ?string $notes;

    /**
     *
     * @ORM\Column(type="string", length=2, nullable=false, options={"default"="1"})
     */
    private string $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $thumbprint;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $feeFixed;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->name = '';
        $this->status = '1';
        $this->totalCost = 0.0;
        $this->feeFixed = false;
        $this->domain = null;
        $this->account = null;
        $this->type = null;
        $this->ip = null;
        $this->category = null;
        $this->notes = null;
        $this->thumbprint = null;
        $this->expiryDate = (new DateTime())->add(new DateInterval('P1Y'));
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

    public function getExpiryDate(): ?DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(DateTime $expiryDate): self
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

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate()
     */
    public function prePersist(): void
    {
        $this->setSslProvider($this->getAccount()
            ->getSslProvider())
            ->setOwner($this->getAccount()
                ->getOwner());
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

    public function getThumbprint(): ?string
    {
        return $this->thumbprint;
    }

    public function setThumbprint(?string $thumbprint): self
    {
        $this->thumbprint = $thumbprint;
        return $this;
    }
}
