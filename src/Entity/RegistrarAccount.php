<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistrarAccounts
 *
 * @ORM\Table(name="registrar_accounts", indexes={@ORM\Index(name="registrar_id", columns={"registrar_id"})})
 * @ORM\Entity
 */
class RegistrarAccount
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner", inversedBy="accounts")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var Registrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="accounts")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=false)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="reseller", type="boolean", nullable=false)
     */
    private $reseller = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="reseller_id", type="string", length=100, nullable=false)
     */
    private $resellerId;

    /**
     * @var string
     *
     * @ORM\Column(name="api_app_name", type="string", length=255, nullable=false)
     */
    private $apiAppName;

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="string", length=255, nullable=false)
     */
    private $apiKey;

    /**
     * @var string
     *
     * @ORM\Column(name="api_secret", type="string", length=255, nullable=false)
     */
    private $apiSecret;

    /**
     * @var int
     *
     * @ORM\Column(name="api_ip_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $apiIpId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     * @var bool
     *
     * @ORM\Column(name="creation_type_id", type="boolean", nullable=false, options={"default"="2"})
     */
    private $creationTypeId = '2';

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $createdBy = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime = '\'1970-01-01 00:00:00\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime = '\'1970-01-01 00:00:00\'';

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }
    
    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }
    
    public function __toString()
    {
        return sprintf("%s, %s (%s)", $this->registrar->getName(), $this->owner->getName(), $this->username);
    }
}
