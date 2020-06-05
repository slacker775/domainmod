<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiRegistrars
 *
 * @ORM\Table(name="api_registrars")
 * @ORM\Entity
 */
class ApiRegistrar
{

    /**
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_account_username", type="boolean", nullable=false)
     */
    private $reqAccountUsername = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_account_password", type="boolean", nullable=false)
     */
    private $reqAccountPassword = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_reseller_id", type="boolean", nullable=false)
     */
    private $reqResellerId = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_api_app_name", type="boolean", nullable=false)
     */
    private $reqApiAppName = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_api_key", type="boolean", nullable=false)
     */
    private $reqApiKey = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_api_secret", type="boolean", nullable=false)
     */
    private $reqApiSecret = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="req_ip_address", type="boolean", nullable=false)
     */
    private $reqIpAddress = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="lists_domains", type="boolean", nullable=false)
     */
    private $listsDomains = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ret_expiry_date", type="boolean", nullable=false)
     */
    private $retExpiryDate = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ret_dns_servers", type="boolean", nullable=false)
     */
    private $retDnsServers = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ret_privacy_status", type="boolean", nullable=false)
     */
    private $retPrivacyStatus = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ret_autorenewal_status", type="boolean", nullable=false)
     */
    private $retAutorenewalStatus = '0';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

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
        $this->reqAccountUsername = false;
        $this->reqAccountPassword = false;
        $this->reqResellerId = false;
        $this->reqApiAppName = false;
        $this->reqApiKey = false;
        $this->reqpApiSecret = false;
        $this->reqIpAddress = false;
        $this->listsDomains = false;
        $this->retExpiryDate = false;
        $this->retDnsServers = false;
        $this->retPrivacyStatus = false;
        $this->retAutorenewalStatus = false;        
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isReqAccountUsername()
    {
        return $this->reqAccountUsername;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isReqAccountPassword()
    {
        return $this->reqAccountPassword;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isReqResellerId()
    {
        return $this->reqResellerId;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isReqApiAppName()
    {
        return $this->reqApiAppName;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isReqApiKey()
    {
        return $this->reqApiKey;
    }

    /**
     * @return string
     */
    public function isReqApiSecret()
    {
        return $this->reqApiSecret;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isReqIpAddress()
    {
        return $this->reqIpAddress;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isListsDomains()
    {
        return $this->listsDomains;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isRetExpiryDate()
    {
        return $this->retExpiryDate;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isRetDnsServers()
    {
        return $this->retDnsServers;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isRetPrivacyStatus()
    {
        return $this->retPrivacyStatus;
    }

    /**
     * @return Ambigous <string, boolean>
     */
    public function isRetAutorenewalStatus()
    {
        return $this->retAutorenewalStatus;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
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
}
