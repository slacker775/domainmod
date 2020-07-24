<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * SegmentData
 *
 * @ORM\Entity
 */
class SegmentData
{

    use EntityIdTrait;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Segment", inversedBy="segmentData")
     */
    private Segment $segment;

    /**
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private string $domain;

    /**
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private bool $active;

    /**
     *
     * @ORM\Column(name="inactive", type="boolean", nullable=false)
     */
    private bool $inactive;

    /**
     *
     * @ORM\Column(name="missing", type="boolean", nullable=false)
     */
    private bool $missing;

    /**
     *
     * @ORM\Column(name="filtered", type="boolean", nullable=false)
     */
    private bool $filtered;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->active = false;
        $this->inactive = false;
        $this->missing = false;
        $this->filtered = false;
    }

    static public function create(string $domain)
    {
        $obj = new self();
        $obj->setDomain($domain);
        return $obj;
    }

    public function getSegment(): Segment
    {
        return $this->segment;
    }

    public function setSegment(Segment $segment): self
    {
        $this->segment = $segment;
        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
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

    public function isInactive(): bool
    {
        return $this->inactive;
    }

    public function setInactive(bool $inactive = true): self
    {
        $this->inactive = $inactive;
        return $this;
    }

    public function isMissing(): bool
    {
        return $this->missing;
    }

    public function setMissing(bool $missing = true): self
    {
        $this->missing = $missing;
        return $this;
    }

    public function isFiltered(): bool
    {
        return $this->filtered;
    }

    public function setFiltered(bool $filtered = true): self
    {
        $this->filtered = $filtered;
        return $this;
    }
}
