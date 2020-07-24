<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 * @ORM\Entity
 */
class Scheduler
{

    use EntityIdTrait;

    /**
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $name;

    /**
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $slug;

    /**
     *
     * @ORM\Column(type="text", length=0, nullable=true)
     */
    private string $description;

    /**
     *
     * @ORM\Column(type="string", length=50, nullable=false, options={"default"="'Daily'"})
     */
    private string $interval;

    /**
     *
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private string $expression;

    /**
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $lastRun;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $lastDuration;

    /**
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $nextRun;

    /**
     *
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default"="1"})
     */
    private int $sortOrder;

    /**
     *
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $isRunning;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default"="1"})
     */
    private bool $active;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->interval = 'Daily';
        $this->expression = '\'0 7 * * * *\'';
        $this->sortOrder = 1;
        $this->isRunning = false;
        $this->active = true;
        $this->lastRun = null;
        $this->lastDuration = null;
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getInterval(): string
    {
        return $this->interval;
    }

    public function setInterval(string $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function setExpression(string $expression): self
    {
        $this->expression = $expression;
        return $this;
    }

    public function getLastRun(): ?DateTimeInterface
    {
        return $this->lastRun;
    }

    public function setLastRun(DateTimeInterface $lastRun): self
    {
        $this->lastRun = $lastRun;
        return $this;
    }

    public function getLastDuration(): ?string
    {
        return $this->lastDuration;
    }

    public function setLastDuration(string $lastDuration): self
    {
        $this->lastDuration = $lastDuration;
        return $this;
    }

    public function getNextRun(): ?DateTimeInterface
    {
        return $this->nextRun;
    }

    public function setNextRun(DateTimeInterface $nextRun): self
    {
        $this->nextRun = $nextRun;
        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    public function isIsRunning(): bool
    {
        return $this->isRunning;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active = true): self
    {
        $this->active = $active;
        return $this;
    }

    public function setRunning(bool $isRunning = true): self
    {
        $this->isRunning = $isRunning;
        return $this;
    }
}
