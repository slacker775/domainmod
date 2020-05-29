<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table(name="domains", indexes={@ORM\Index(name="domain", columns={"domain"})})
 * @ORM\Entity
 */
class Domain
{

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * 
     */
    private $owner;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="registrar_id", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $registrarId = '1';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $accountId = '1';

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
     * @ORM\Column(name="expiry_date", type="date", nullable=false, options={"default"="'1970-01-01'"})
     */
    private $expiryDate = '\'1970-01-01\'';

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="id")
     * 
     * @var Category
     */
    private $category;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="fee_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $feeId = '0';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="total_cost", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalCost;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="dns_id", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $dnsId = '1';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="ip_id", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $ipId = '1';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="hosting_id", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $hostingId = '1';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="function", type="string", length=255, nullable=false)
     */
    private $function;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="autorenew", type="boolean", nullable=false)
     */
    private $autorenew = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="privacy", type="boolean", nullable=false)
     */
    private $privacy = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="fee_fixed", type="boolean", nullable=false)
     */
    private $feeFixed = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="creation_type_id", type="boolean", nullable=false, options={"default"="2"})
     */
    private $creationTypeId = '2';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $createdBy = '0';

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime = '\'1970-01-01 00:00:00\'';

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime = '\'1970-01-01 00:00:00\'';

    /**
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return number
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     *
     * @return number
     */
    public function getRegistrarId()
    {
        return $this->registrarId;
    }

    /**
     *
     * @return number
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     *
     * @return string
     */
    public function getTld()
    {
        return $this->tld;
    }

    /**
     *
     * @return DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     *
     * @return number
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     *
     * @return number
     */
    public function getFeeId()
    {
        return $this->feeId;
    }

    /**
     *
     * @return string
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     *
     * @return number
     */
    public function getDnsId()
    {
        return $this->dnsId;
    }

    /**
     *
     * @return number
     */
    public function getIpId()
    {
        return $this->ipId;
    }

    /**
     *
     * @return number
     */
    public function getHostingId()
    {
        return $this->hostingId;
    }

    /**
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     *
     * @return boolean
     */
    public function isAutorenew()
    {
        return $this->autorenew;
    }

    /**
     *
     * @return boolean
     */
    public function isPrivacy()
    {
        return $this->privacy;
    }

    /**
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     *
     * @return boolean
     */
    public function isFeeFixed()
    {
        return $this->feeFixed;
    }

    /**
     *
     * @return boolean
     */
    public function isCreationTypeId()
    {
        return $this->creationTypeId;
    }

    /**
     *
     * @return number
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     *
     * @return DateTime
     */
    public function getInsertTime()
    {
        return $this->insertTime;
    }

    /**
     *
     * @return DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     *
     * @param number $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    /**
     *
     * @param number $registrarId
     */
    public function setRegistrarId($registrarId)
    {
        $this->registrarId = $registrarId;
        return $this;
    }

    /**
     *
     * @param number $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     *
     * @param string $tld
     */
    public function setTld($tld)
    {
        $this->tld = $tld;
        return $this;
    }

    /**
     *
     * @param DateTime $expiryDate
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    /**
     *
     * @param number $catId
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
        return $this;
    }

    /**
     *
     * @param number $feeId
     */
    public function setFeeId($feeId)
    {
        $this->feeId = $feeId;
        return $this;
    }

    /**
     *
     * @param string $totalCost
     */
    public function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    /**
     *
     * @param number $dnsId
     */
    public function setDnsId($dnsId)
    {
        $this->dnsId = $dnsId;
        return $this;
    }

    /**
     *
     * @param number $ipId
     */
    public function setIpId($ipId)
    {
        $this->ipId = $ipId;
        return $this;
    }

    /**
     *
     * @param number $hostingId
     */
    public function setHostingId($hostingId)
    {
        $this->hostingId = $hostingId;
        return $this;
    }

    /**
     *
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
        return $this;
    }

    /**
     *
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     *
     * @param boolean $autorenew
     */
    public function setAutorenew($autorenew)
    {
        $this->autorenew = $autorenew;
        return $this;
    }

    /**
     *
     * @param boolean $privacy
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
        return $this;
    }

    /**
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     *
     * @param boolean $feeFixed
     */
    public function setFeeFixed($feeFixed)
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }

    /**
     *
     * @param boolean $creationTypeId
     */
    public function setCreationTypeId($creationTypeId)
    {
        $this->creationTypeId = $creationTypeId;
        return $this;
    }

    /**
     *
     * @param number $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     *
     * @param DateTime $insertTime
     */
    public function setInsertTime($insertTime)
    {
        $this->insertTime = $insertTime;
        return $this;
    }

    /**
     *
     * @param DateTime $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
        return $this;
    }
}
