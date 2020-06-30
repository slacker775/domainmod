<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Segments
 *
 * @ORM\Table(name="segments")
 * @ORM\Entity
 */
class Segment
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
     * @ORM\Column(name="name", type="string", length=35, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="segment", type="text", length=0, nullable=false)
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
     * @ORM\Column(name="number_of_domains", type="integer", nullable=false)
     */
    private $numberOfDomains;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     *
     * @var CreationType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CreationType")
     * @ORM\JoinColumn(name="creation_type_id", referencedColumnName="id")
     */
    private $creationType;

    /**
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

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
        $this->segmentData = new ArrayCollection();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSegment(): string
    {
        return $this->segment;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getSegmentData(): Collection
    {
        return $this->segmentData;
    }

    public function getCreationType(): CreationType
    {
        return $this->creationType;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getNumberOfDomains(): int
    {
        return $this->numberOfDomains;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setSegment(string $segment): self
    {
        $this->segment = $segment;
        return $this;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function setNumberOfDomains(int $numberOfDomains): self
    {
        $this->numberOfDomains = $numberOfDomains;
        return $this;
    }

    public function setSegmentData(Collection $segmentData): self
    {
        $this->segmentData = $segmentData;
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

    public function setCreationType(CreationType $creationType): self
    {
        $this->creationType = $creationType;
        return $this;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
