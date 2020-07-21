<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Currencies
 *
 * @ORM\Entity
 */
class Currency
{
    use EntityIdTrait;

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

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->symbolOrder = false;
        $this->symbolSpace = false;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }

    public function isSymbolOrder(): bool
    {
        return $this->symbolOrder;
    }

    public function setSymbolOrder(bool $symbolOrder): self
    {
        $this->symbolOrder = $symbolOrder;
        return $this;
    }

    public function isSymbolSpace(): bool
    {
        return $this->symbolSpace;
    }

    public function setSymbolSpace(bool $symbolSpace): self
    {
        $this->symbolSpace = $symbolSpace;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }
}
