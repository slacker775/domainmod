<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Segments
 *
 * @ORM\Table(name="segments")
 * @ORM\Entity
 */
class Segment
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
     * @ORM\Column(name="name", type="string", length=35, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="segment", type="text", length=0, nullable=false)
     */
    private $segment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SegmentData", mappedBy="segment")
     * 
     * @var Collection
     */
    private $segmentData;
    
    /**
     * @var int
     *
     * @ORM\Column(name="number_of_domains", type="integer", nullable=false)
     */
    private $numberOfDomains;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     * @var bool
     *
     * @ORM\Column(name="creation_type_id", type="boolean", nullable=false, options={"default"="2"})
     */
    private $creationTypeId = '2';

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $createdBy = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->segmentData = new ArrayCollection();
    }
    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $segment
     */
    public function setSegment($segment)
    {
        $this->segment = $segment;
        return $this;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
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
}
