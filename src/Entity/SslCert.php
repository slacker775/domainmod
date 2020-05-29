<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SslCerts
 *
 * @ORM\Table(name="ssl_certs")
 * @ORM\Entity
 */
class SslCert
{

    const STATUS_PENDING_RENEWAL = 3;

    const STATUS_PENDING_OTHER = 4;

    const STATUS_PENDING_REGISTRATION = 5;

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
     * @var int
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $ownerId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="ssl_provider_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $sslProviderId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $accountId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $typeId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="ip_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $ipId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $catId;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=false, options={"default"="'1970-01-01'"})
     */
    private $expiryDate = '\'1970-01-01\'';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="fee_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $feeId;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="total_cost", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalCost;

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
    public function getSslProviderId()
    {
        return $this->sslProviderId;
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
     * @return number
     */
    public function getDomainId()
    {
        return $this->domainId;
    }

    /**
     *
     * @return number
     */
    public function getTypeId()
    {
        return $this->typeId;
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
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param number $sslProviderId
     */
    public function setSslProviderId($sslProviderId)
    {
        $this->sslProviderId = $sslProviderId;
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
     * @param number $domainId
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;
        return $this;
    }

    /**
     *
     * @param number $typeId
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
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
     * @param number $catId
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
        return $this;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
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
