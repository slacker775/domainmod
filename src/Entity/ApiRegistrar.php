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
     * @var bool
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
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime;

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __toString(): ?string
    {
        return $this->name;
    }
}
