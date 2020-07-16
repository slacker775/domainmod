<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Fees
 *
 * @ORM\Entity
 */
class Fee
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
     * @var Registrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="fees")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private $tld;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="initial_fee", type="float", nullable=false)
     */
    private $initialFee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="renewal_fee", type="float", nullable=false)
     */
    private $renewalFee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="transfer_fee", type="float", nullable=false)
     */
    private $transferFee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="privacy_fee", type="float", nullable=false)
     */
    private $privacyFee;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="misc_fee", type="float", nullable=false)
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
        $this->fixedFee = false;
        $this->initialFee = 0;
        $this->renewalFee = 0.0;
        $this->transferFee = 0.0;
        $this->privacyFee = 0.0;
        $this->miscFee = 0.0;
        $this->feeFixed = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }

    public function getTld(): ?string
    {
        return $this->tld;
    }

    public function getInitialFee(): float
    {
        return $this->initialFee;
    }

    public function getRenewalFee(): float
    {
        return $this->renewalFee;
    }

    public function getTransferFee(): float
    {
        return $this->transferFee;
    }

    public function getPrivacyFee(): float
    {
        return $this->privacyFee;
    }

    public function getMiscFee(): float
    {
        return $this->miscFee;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function isFeeFixed(): bool
    {
        return $this->feeFixed;
    }

    public function setRegistrar(Registrar $registrar): self
    {
        $this->registrar = $registrar;
        return $this;
    }

    public function setTld(string $tld): self
    {
        $this->tld = $tld;
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

    public function setTransferFee(float $transferFee): self
    {
        $this->transferFee = $transferFee;
        return $this;
    }

    public function setPrivacyFee(float $privacyFee): self
    {
        $this->privacyFee = $privacyFee;
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
        return sprintf("%s - %s", $this->getRegistrar()->getName(), $this->tld);
    }
}
