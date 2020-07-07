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
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=4, nullable=false)
     */
    private $currency;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=75, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=4, nullable=false)
     */
    private $symbol;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="symbol_order", type="boolean", nullable=false)
     */
    private $symbolOrder;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="symbol_space", type="boolean", nullable=false)
     */
    private $symbolSpace;

    /**
     *
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
        $this->symbolOrder = false;
        $this->symbolSpace = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function isSymbolOrder(): bool
    {
        return $this->symbolOrder;
    }

    public function isSymbolSpace(): bool
    {
        return $this->symbolSpace;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }

    public function setSymbolOrder(bool $symbolOrder): self
    {
        $this->symbolOrder = $symbolOrder;
        return $this;
    }

    public function setSymbolSpace(bool $symbolSpace): self
    {
        $this->symbolSpace = $symbolSpace;
        return $this;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }
}
