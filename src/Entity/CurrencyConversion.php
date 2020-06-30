<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyConversions
 *
 * @ORM\Table(name="currency_conversions")
 * @ORM\Entity
 */
class CurrencyConversion
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
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency")
     * @ORM\Column(name="currency_id", referencedColumnName="id")
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

    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
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
