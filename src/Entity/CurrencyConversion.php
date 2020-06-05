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
     * @var int
     *
     * @ORM\Column(name="currency_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $currencyId;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userId;

    /**
     *
     * @var string
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
}
