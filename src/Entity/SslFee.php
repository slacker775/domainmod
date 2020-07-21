<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * SslFees
 *
 * @ORM\Entity
 */
class SslFee
{

    use EntityIdTrait;

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

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->feeFixed = false;
    }

    public function getInitialFee(): float
    {
        return $this->initialFee;
    }

    public function setInitialFee(float $initialFee): self
    {
        $this->initialFee = $initialFee;
        return $this;
    }

    public function getRenewalFee(): float
    {
        return $this->renewalFee;
    }

    public function setRenewalFee(float $renewalFee): self
    {
        $this->renewalFee = $renewalFee;
        return $this;
    }

    public function getMiscFee(): float
    {
        return $this->miscFee;
    }

    public function setMiscFee(float $miscFee): self
    {
        $this->miscFee = $miscFee;
        return $this;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function isFeeFixed(): bool
    {
        return $this->feeFixed;
    }

    public function setFeeFixed(bool $feeFixed = true): self
    {
        $this->feeFixed = $feeFixed;
        return $this;
    }

    public function __toString()
    {
        return sprintf("%s", $this->getSslProvider()
            ->getName());
    }

    public function getSslProvider(): SslProvider
    {
        return $this->sslProvider;
    }

    public function setSslProvider(SslProvider $sslProvider): self
    {
        $this->sslProvider = $sslProvider;
        return $this;
    }
}
