<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Segments
 *
 * @ORM\Entity
 */
class Segment
{

    use EntityIdTrait;

    /**
     *
     * @var string
     *
     * @ORM\Column(type="string", length=35, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(type="text", length=0, nullable=false)
     */
    private $description;

    /**
     *
     * @var string
     *
     * @ORM\Column(type="text", length=0, nullable=false)
     */
    private $segment;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SegmentData", mappedBy="segment")
     *
     * @var Collection
     */
    private $segmentData;

    /**
     *
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $numberOfDomains;

    /**
     *
     * @var string
     *
     * @ORM\Column(type="text", length=0, nullable=false)
     */
    private $notes;

    use CreationTypeTrait;

    use BlameableEntity;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->segmentData = new ArrayCollection();
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getSegment(): string
    {
        return $this->segment;
    }

    public function setSegment(string $segment): self
    {
        $this->segment = $segment;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getSegmentData(): Collection
    {
        return $this->segmentData;
    }

    public function setSegmentData(Collection $segmentData): self
    {
        $this->segmentData = $segmentData;
        return $this;
    }

    public function getNumberOfDomains(): int
    {
        return $this->numberOfDomains;
    }

    public function setNumberOfDomains(int $numberOfDomains): self
    {
        $this->numberOfDomains = $numberOfDomains;
        return $this;
    }

    public function addSegmentData(SegmentData $data): self
    {
        if ($this->segmentData->contains($data) === false) {
            $this->segmentData->add($data);
        }
        return $this;
    }

    public function removeSegmentData(SegmentData $data): self
    {
        if ($this->segmentData->contains($data) === true) {
            $this->segmentData->removeElement($data);
        }
        return $this;
    }


}
