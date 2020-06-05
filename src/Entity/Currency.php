<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currencies
 *
 * @ORM\Table(name="currencies")
 * @ORM\Entity
 */
class Currency
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
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=4, nullable=false)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=75, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=4, nullable=false)
     */
    private $symbol;

    /**
     * @var bool
     *
     * @ORM\Column(name="symbol_order", type="boolean", nullable=false)
     */
    private $symbolOrder = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="symbol_space", type="boolean", nullable=false)
     */
    private $symbolSpace = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=true)
     */
    private $notes;

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
