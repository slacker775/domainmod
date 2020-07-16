<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Scheduler
 *
 * @ORM\Entity
 */
class Scheduler
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50, nullable=true)
     */
    private $slug;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="interval", type="string", length=50, nullable=false, options={"default"="'Daily'"})
     */
    private $interval;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="expression", type="string", length=20, nullable=false)
     */
    private $expression;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="last_run", type="datetime", nullable=true)
     */
    private $lastRun;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="last_duration", type="string", length=255, nullable=true)
     */
    private $lastDuration;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="next_run", type="datetime", nullable=true)
     */
    private $nextRun;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=false, options={"default"="1"})
     */
    private $sortOrder;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="is_running", type="boolean", nullable=false)
     */
    private $isRunning;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active;

    use TimestampableEntity;    

    public function __construct()
    {
        $this->interval = 'Daily';
        $this->expression = '\'0 7 * * * *\'';
        $this->sortOrder = 1;
        $this->isRunning = false;
        $this->active = true;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getInterval(): string
    {
        return $this->interval;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function getLastRun(): ?\DateTimeInterface
    {
        return $this->lastRun;
    }

    public function getLastDuration(): ?string
    {
        return $this->lastDuration;
    }

    public function getNextRun(): ?\DateTimeInterface
    {
        return $this->nextRun;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function isIsRunning(): bool
    {
        return $this->isRunning;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setInterval(string $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    public function setExpression(string $expression): self
    {
        $this->expression = $expression;
        return $this;
    }

    public function setLastRun(\DateTimeInterface $lastRun): self
    {
        $this->lastRun = $lastRun;
        return $this;
    }

    public function setLastDuration(string $lastDuration): self
    {
        $this->lastDuration = $lastDuration;
        return $this;
    }

    public function setNextRun(\DateTimeInterface $nextRun): self
    {
        $this->nextRun = $nextRun;
        return $this;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    public function setRunning(bool $isRunning = true): self
    {
        $this->isRunning = $isRunning;
        return $this;
    }

    public function setActive(bool $active = true): self
    {
        $this->active = $active;
        return $this;
    }
}
