<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Domains
 *
 * @ORM\Entity
 * @ORM\Table(indexes={@ORM\Index(name="domain_name_idx", columns={"name"})})
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

    use EntityIdTrait;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="domains")*
     */
    private Owner $owner;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="domains")
     */
    private ?Registrar $registrar;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount", inversedBy="domains")
     */
    private ?RegistrarAccount $account;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Hostname
     * @Assert\NotBlank
     */
    private string $name;

    /**
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private ?string $tld;

    /**
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private DateTimeInterface $expiryDate;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="domains")
     */
    private ?Category $category;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Fee")
     */
    private ?Fee $fee;

    /**
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private float $totalCost;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Dns", inversedBy="domains")
     */
    private ?Dns $dns;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress", inversedBy="domains")
     */
    private ?IpAddress $ip;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting", inversedBy="domains")
     */
    private ?Hosting $hosting;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $function;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private ?string $notes;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $autorenew;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $privacy;

    /**
     *
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private bool $transferLock;

    /**
     *
     * @ORM\Column(type="string", length=2, nullable=false, options={"default"="1"})
     */
    private string $status;

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
        $this->status = '1';
        $this->totalCost = 0;
        $this->feeFixed = false;
        $this->autorenew = false;
        $this->privacy = false;
        $this->transferLock = false;
        $this->function = null;
        $this->notes = null;
        $this->tld = null;
        $this->name = '';
        $this->expiryDate = (new \DateTime())->add(new \DateInterval('P1Y'));
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

    public function getRegistrar(): ?Registrar
    {
        return $this->registrar;
    }

    public function setRegistrar(?Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function getAccount(): ?RegistrarAccount
    {
        return $this->account;
    }

    public function setAccount(?RegistrarAccount $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function setTld(string $tld = null): self
    {
        if ($tld === null and $this->name !== null) {
            $tld = preg_replace("/^((.*?)\.)(.*)$/", "\\3", $this->name);
        }
        $this->tld = $tld;
        return $this;
    }

    public function getExpiryDate(): ?DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getFee(): ?Fee
    {
        return $this->fee;
    }

    public function setFee(?Fee $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    public function getDns(): ?Dns
    {
        return $this->dns;
    }

    public function setDns(?Dns $dns): self
    {
        $this->dns = $dns;
        return $this;
    }

    public function getIp(): ?IpAddress
    {
        return $this->ip;
    }

    public function setIp(?IpAddress $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @deprecated
     */
    public function getHostingProvider(): ?Hosting
    {
        return $this->getHosting();
    }

    public function getHosting(): ?Hosting
    {
        return $this->hosting;
    }

    /**
     * @deprecated
     */
    public function setHostingProvider(?Hosting $hosting): self
    {
        return $this->setHosting($hosting);
    }

    public function setHosting(?Hosting $hosting): self
    {
        $this->hosting = $hosting;
        return $this;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(?string $function): self
    {
        $function = $function ?? '';
        $this->function = $function;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $notes = $notes ?? '';
        $this->notes = $notes;
        return $this;
    }

    public function isAutorenew(): bool
    {
        return $this->autorenew;
    }

    public function setAutorenew(bool $autorenew = false): self
    {
        $this->autorenew = $autorenew;
        return $this;
    }

    public function isPrivacy(): bool
    {
        return $this->privacy;
    }

    public function setPrivacy(bool $privacy = false): self
    {
        $this->privacy = $privacy;
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

    public function setFeeFixed(bool $feeFixed = false): self
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function isTransferLock(): bool
    {
        return $this->transferLock;
    }

    public function setTransferLock($transferLock = true): self
    {
        $this->transferLock = $transferLock;
        return $this;
    }
}
