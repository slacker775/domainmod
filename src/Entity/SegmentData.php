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
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Segment", inversedBy="segmentData")
     * @ORM\JoinColumn(name="segment_id", referencedColumnName="id")
     */
    private $segment;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="inactive", type="boolean", nullable=false)
     */
    private $inactive = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="missing", type="boolean", nullable=false)
     */
    private $missing = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="filtered", type="boolean", nullable=false)
     */
    private $filtered = '0';

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


}
