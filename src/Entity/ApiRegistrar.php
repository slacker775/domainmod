<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ApiRegistrars
 *
 * @ORM\Entity
 */
class ApiRegistrar
{
    use EntityIdTrait;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqAccountUsername;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqAccountPassword;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqResellerId;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqApiAppName;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqApiKey;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqApiSecret;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     */
    private bool $reqApiToken;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $reqIpAddress;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $listsDomains;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $retExpiryDate;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $retDnsServers;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $retPrivacyStatus;

    /**
     *
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private bool $retTransferLock;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $retAutorenewalStatus;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private ?string $notes;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->reqAccountUsername = false;
        $this->reqAccountPassword = false;
        $this->reqResellerId = false;
        $this->reqApiAppName = false;
        $this->reqApiKey = false;
        $this->reqApiSecret = false;
        $this->reqIpAddress = false;
        $this->listsDomains = false;
        $this->retExpiryDate = false;
        $this->retDnsServers = false;
        $this->retPrivacyStatus = false;
        $this->retAutorenewalStatus = false;
    }

    public function reqAccountUsername(): bool
    {
        return $this->reqAccountUsername;
    }

    public function reqAccountPassword(): bool
    {
        return $this->reqAccountPassword;
    }

    public function reqResellerId(): bool
    {
        return $this->reqResellerId;
    }

    public function reqApiAppName(): bool
    {
        return $this->reqApiAppName;
    }

    public function reqApiKey(): bool
    {
        return $this->reqApiKey;
    }

    public function reqApiSecret(): bool
    {
        return $this->reqApiSecret;
    }

    public function reqIpAddress(): bool
    {
        return $this->reqIpAddress;
    }

    public function listsDomains(): bool
    {
        return $this->listsDomains;
    }

    public function retExpiryDate(): bool
    {
        return $this->retExpiryDate;
    }

    public function retDnsServers(): bool
    {
        return $this->retDnsServers;
    }

    public function retPrivacyStatus(): bool
    {
        return $this->retPrivacyStatus;
    }

    public function retAutorenewalStatus(): bool
    {
        return $this->retAutorenewalStatus;
    }

    public function setReqAccountUsername(bool $reqAccountUsername = true): self
    {
        $this->reqAccountUsername = $reqAccountUsername;
        return $this;
    }

    public function setReqAccountPassword(bool $reqAccountPassword = true): self
    {
        $this->reqAccountPassword = $reqAccountPassword;
        return $this;
    }

    public function setReqResellerId(bool $reqResellerId = true): self
    {
        $this->reqResellerId = $reqResellerId;
        return $this;
    }

    public function setReqApiAppName(bool $reqApiAppName = true): self
    {
        $this->reqApiAppName = $reqApiAppName;
        return $this;
    }

    public function setReqApiKey(bool $reqApiKey = true): self
    {
        $this->reqApiKey = $reqApiKey;
        return $this;
    }

    public function setReqApiSecret(bool $reqApiSecret = true): self
    {
        $this->reqApiSecret = $reqApiSecret;
        return $this;
    }

    public function setReqIpAddress(bool $reqIpAddress = true): self
    {
        $this->reqIpAddress = $reqIpAddress;
        return $this;
    }

    public function setListsDomains(bool $listsDomains = true): self
    {
        $this->listsDomains = $listsDomains;
        return $this;
    }

    public function setRetExpiryDate(bool $retExpiryDate = true): self
    {
        $this->retExpiryDate = $retExpiryDate;
        return $this;
    }

    public function setRetDnsServers(bool $retDnsServers = true): self
    {
        $this->retDnsServers = $retDnsServers;
        return $this;
    }

    public function setRetPrivacyStatus(bool $retPrivacyStatus = true): self
    {
        $this->retPrivacyStatus = $retPrivacyStatus;
        return $this;
    }

    public function setRetAutorenewalStatus(bool $retAutorenewalStatus = true): self
    {
        $this->retAutorenewalStatus = $retAutorenewalStatus;
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

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function __toString(): ?string
    {
        return $this->name;
    }

    public function isRetTransferLock(): bool
    {
        return $this->retTransferLock;
    }

    public function setRetTransferLock(bool $retTransferLock = true): self
    {
        $this->retTransferLock = $retTransferLock;
        return $this;
    }

    public function isReqApiToken(): bool
    {
        return $this->reqApiToken;
    }

    public function setReqApiToken(bool $reqApiToken = true): self
    {
        $this->reqApiToken = $reqApiToken;
        return $this;
    }
}
