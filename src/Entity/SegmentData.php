<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SegmentData
 *
 * @ORM\Table(name="segment_data")
 * @ORM\Entity
 */
class SegmentData
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
     * @var Segment
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Segment", inversedBy="segmentData")
     * @ORM\JoinColumn(name="segment_id", referencedColumnName="id")
     */
    private $segment;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="inactive", type="boolean", nullable=false)
     */
    private $inactive;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="missing", type="boolean", nullable=false)
     */
    private $missing;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="filtered", type="boolean", nullable=false)
     */
    private $filtered;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->active = false;
        $this->inactive = false;
        $this->missing = false;
        $this->filtered = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSegment(): Segment
    {
        return $this->segment;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isInactive(): bool
    {
        return $this->inactive;
    }

    public function isMissing(): bool
    {
        return $this->missing;
    }

    public function isFiltered(): bool
    {
        return $this->filtered;
    }

    public function setSegment(Segment $segment): self
    {
        $this->segment = $segment;
        return $this;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;
        return $this;
    }

    public function setActive(bool $active = true): self
    {
        $this->active = $active;
        return $this;
    }

    public function setInactive(bool $inactive = true): self
    {
        $this->inactive = $inactive;
        return $this;
    }

    public function setMissing(bool $missing = true): self
    {
        $this->missing = $missing;
        return $this;
    }

    public function setFiltered(bool $filtered = true): self
    {
        $this->filtered = $filtered;
        return $this;
    }
}
