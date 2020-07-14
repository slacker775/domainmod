<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SslFees
 *
 * @ORM\Table(name="ssl_fees")
 * @ORM\Entity
 */
class SslFee
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
     * @var SslProvider
     *
     * @ORM\OneToOne(targetEntity="App\Entity\SslProvider", inversedBy="fee")
     * @ORM\JoinColumn(name="ssl_provider_id", referencedColumnName="id")
     */
    private $sslProvider;

    /**
     *
     * @var SslCertType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslCertType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="initial_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $initialFee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="renewal_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $renewalFee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="misc_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $miscFee;

    /**
     *
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    private $currency;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="fee_fixed", type="boolean", nullable=false)
     */
    private $feeFixed;

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
        $this->feeFixed = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSslProvider(): SslProvider
    {
        return $this->sslProvider;
    }

    public function getInitialFee(): float
    {
        return $this->initialFee;
    }

    public function getRenewalFee(): float
    {
        return $this->renewalFee;
    }

    public function getMiscFee(): float
    {
        return $this->miscFee;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function isFeeFixed(): bool
    {
        return $this->feeFixed;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function getUpdated(): \DateTimeInterface
    {
        return $this->updated;
    }

    public function setSslProvider(SslProvider $sslProvider): self
    {
        $this->sslProvider = $sslProvider;
        return $this;
    }

    public function setInitialFee(float $initialFee): self
    {
        $this->initialFee = $initialFee;
        return $this;
    }

    public function setRenewalFee(float $renewalFee): self
    {
        $this->renewalFee = $renewalFee;
        return $this;
    }

    public function setMiscFee(float $miscFee): self
    {
        $this->miscFee = $miscFee;
        return $this;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setFeeFixed(bool $feeFixed = true): self
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }
    
    public function __toString()
    {
        return sprintf("%s", $this->getSslProvider()->getName());
    }
}
