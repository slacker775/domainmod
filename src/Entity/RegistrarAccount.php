<?php
declare(strict_types = 1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RegistrarAccounts
 *
 * @ORM\Table(name="registrar_accounts", indexes={@ORM\Index(name="registrar_id", columns={"registrar_id"})})
 * @ORM\Entity
 */
class RegistrarAccount
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="accounts")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=true)
     */
    private $emailAddress;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="reseller", type="boolean", nullable=false)
     */
    private $reseller;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="reseller_id", type="string", length=100, nullable=true)
     */
    private $resellerId;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="api_app_name", type="string", length=255, nullable=true)
     */
    private $apiAppName;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=255, nullable=true)
     */
    private $apiKey;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="api_secret", type="string", length=255, nullable=true)
     */
    private $apiSecret;

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     * @ORM\JoinColumn(name="api_ip_id", referencedColumnName="id")
     */
    private $apiIp;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="account")
     * @var Collection
     */
    private $domains;

    /**
     *
     * @var CreationType
     *
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
        $this->domains = new ArrayCollection();
        $this->reseller = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isReseller(): bool
    {
        return $this->reseller;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setReseller(bool $reseller = true): self
    {
        $this->reseller = $reseller;
        return $this;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
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

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function getActiveDomainCount(): int
    {
        return count($this->getDomains()->filter(function (Domain $domain) {
            return $domain->getStatus() != Domain::STATUS_EXPIRED && $domain->getStatus() != Domain::STATUS_SOLD;
        }));
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getResellerId(): ?string
    {
        return $this->resellerId;
    }

    public function getApiAppName()
    {
        return $this->apiAppName;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function getApiSecret(): ?string
    {
        return $this->apiSecret;
    }

    public function getApiIp(): ?IpAddress
    {
        return $this->apiIp;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setResellerId(?string $resellerId): self
    {
        $this->resellerId = $resellerId;
        return $this;
    }

    public function setApiAppName(?string $apiAppName): self
    {
        $this->apiAppName = $apiAppName;
        return $this;
    }

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function setApiSecret(?string $apiSecret): self
    {
        $this->apiSecret = $apiSecret;
        return $this;
    }

    public function setApiIp(IpAddress $ip): self
    {
        $this->apiIp = $ip;
        return $this;
    }

    public function setDomains(Collection $domains): self
    {
        $this->domains = $domains;
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

    public function __toString()
    {
        return sprintf("%s, %s (%s)", $this->registrar->getName(), $this->owner->getName(), $this->username);
    }
}
