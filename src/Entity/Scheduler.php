<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scheduler
 *
 * @ORM\Table(name="scheduler")
 * @ORM\Entity
 */
class Scheduler
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="interval", type="string", length=50, nullable=false, options={"default"="'Daily'"})
     */
    private $interval = '\'Daily\'';

    /**
     * @var string
     *
     * @ORM\Column(name="expression", type="string", length=20, nullable=false, options={"default"="'0 7 * * * *'"})
     */
    private $expression = '\'0 7 * * * *\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_run", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $lastRun = '\'1970-01-01 00:00:00\'';

    /**
     * @var string
     *
     * @ORM\Column(name="last_duration", type="string", length=255, nullable=false)
     */
    private $lastDuration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_run", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $nextRun = '\'1970-01-01 00:00:00\'';

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=false, options={"default"="1"})
     */
    private $sortOrder = '1';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_running", type="boolean", nullable=false)
     */
    private $isRunning = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime = '\'1970-01-01 00:00:00\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime = '\'1970-01-01 00:00:00\'';


}
