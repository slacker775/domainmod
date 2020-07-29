<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Fees
 *
 * @ORM\Entity
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"tld","registrar_id"})
 * })
 */
class Fee
{

    use EntityIdTrait;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar", inversedBy="fees")
     */
    private Registrar $registrar;

    /**
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private string $tld;

    /**
     *
     * @ORM\Column(name="initial_fee", type="float", nullable=false)
     */
    private float $initialFee;

    /**
     *
     * @ORM\Column(name="renewal_fee", type="float", nullable=false)
     */
    private float $renewalFee;

    /**
     *
     * @ORM\Column(name="transfer_fee", type="float", nullable=false)
     */
    private float $transferFee;

    /**
     *
     * @ORM\Column(name="privacy_fee", type="float", nullable=false)
     */
    private float $privacyFee;

    /**
     *
     * @ORM\Column(name="misc_fee", type="float", nullable=false)
     */
    private float $miscFee;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency")
     */
    private ?Currency $currency;

    /**
     *
     * @ORM\Column(name="fee_fixed", type="boolean", nullable=false)
     */
    private bool $feeFixed;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->feeFixed = false;
        $this->initialFee = 0;
        $this->renewalFee = 0.0;
        $this->transferFee = 0.0;
        $this->privacyFee = 0.0;
        $this->miscFee = 0.0;
        $this->feeFixed = false;
        $this->currency = null;
    }

    public function getTld(): ?string
    {
        return $this->tld;
    }

    public function setTld(string $tld): self
    {
        $this->tld = $tld;
        return $this;
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

    public function getTransferFee(): float
    {
        return $this->transferFee;
    }

    public function setTransferFee(float $transferFee): self
    {
        $this->transferFee = $transferFee;
        return $this;
    }

    public function getPrivacyFee(): float
    {
        return $this->privacyFee;
    }

    public function setPrivacyFee(float $privacyFee): self
    {
        $this->privacyFee = $privacyFee;
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

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
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
        return sprintf("%s - %s", $this->getRegistrar()
            ->getName(), $this->tld);
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
}
