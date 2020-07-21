<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * CurrencyConversions
 *
 */
class CurrencyConversion
{
    use EntityIdTrait;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     *
     * @var float
     *
     * @ORM\Column(name="conversion", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $conversion;

    use TimestampableEntity;    

    public function __construct()
    {
        $this->generateId();
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getConversion(): float
    {
        return $this->conversion;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setConversion(float $conversion): self
    {
        $this->conversion = $conversion;
        return $this;
    }
}
