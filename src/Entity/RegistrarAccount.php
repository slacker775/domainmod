<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class RegistrarAccount
{

    use EntityIdTrait;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="registrarAccounts")
     */
    private ?Owner $owner;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="accounts")
     */
    private ?Registrar $registrar;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Email
     */
    private ?string $emailAddress;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank
     */
    private ?string $username;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $password;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reseller;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $resellerId;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $apiAppName;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $apiKey;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $apiSecret;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $apiToken;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     */
    private ?IpAddress $apiIp;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private ?string $notes;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Domain", mappedBy="account")
     */
    private Collection $domains;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->domains = new ArrayCollection();
        $this->reseller = false;
        $this->registrar = null;
        $this->owner = null;
        $this->emailAddress = null;
        $this->username = null;
        $this->password = null;
        $this->resellerId = null;
        $this->apiAppName = null;
        $this->apiKey = null;
        $this->apiSecret = null;
        $this->apiToken = null;
        $this->apiIp = null;
        $this->notes = null;
    }

    public function isReseller(): bool
    {
        return $this->reseller;
    }

    public function setReseller(bool $reseller = true): self
    {
        $this->reseller = $reseller;
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

    public function getActiveDomainCount(): int
    {
        return count($this->getDomains()
            ->filter(function (Domain $domain) {
                return $domain->getStatus() != Domain::STATUS_EXPIRED && $domain->getStatus() != Domain::STATUS_SOLD;
            }));
    }

    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function setDomains(Collection $domains): self
    {
        $this->domains = $domains;
        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getResellerId(): ?string
    {
        return $this->resellerId;
    }

    public function setResellerId(?string $resellerId): self
    {
        $this->resellerId = $resellerId;
        return $this;
    }

    public function getApiAppName()
    {
        return $this->apiAppName;
    }

    public function setApiAppName(?string $apiAppName): self
    {
        $this->apiAppName = $apiAppName;
        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getApiSecret(): ?string
    {
        return $this->apiSecret;
    }

    public function setApiSecret(?string $apiSecret): self
    {
        $this->apiSecret = $apiSecret;
        return $this;
    }

    public function getApiIp(): ?IpAddress
    {
        return $this->apiIp;
    }

    public function setApiIp(?IpAddress $ip): self
    {
        $this->apiIp = $ip;
        return $this;
    }

    public function __toString()
    {
        return sprintf("%s, %s (%s)", $this->registrar->getName(), $this->owner->getName(), $this->username);
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        /*
        If the owner or registrar changes for account assigned for these domains,
        update those values in the underlying domain as well.
        */
        foreach ($this->domains as $domain) {
            $domain->setOwner($this->owner)
                ->setRegistrar($this->registrar);
            $event->getEntityManager()
                ->persist($domain);
        }
    }
}
