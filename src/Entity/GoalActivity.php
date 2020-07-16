<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * GoalActivity
 *
 * @ORM\Entity
 */
class GoalActivity
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
     * @ORM\Column(name="type", type="string", length=7, nullable=false, options={"default"="'unknown'"})
     */
    private $type = '\'unknown\'';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="old_version", type="string", length=10, nullable=false, options={"default"="'unknown'"})
     */
    private $oldVersion = '\'unknown\'';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="new_version", type="string", length=10, nullable=false, options={"default"="'unknown'"})
     */
    private $newVersion = '\'unknown\'';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=45, nullable=false, options={"default"="'unknown'"})
     */
    private $ip = '\'unknown\'';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="agent", type="text", length=0, nullable=false)
     */
    private $agent;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=100, nullable=false, options={"default"="'unknown'"})
     */
    private $language = '\'unknown\'';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="new_activity", type="boolean", nullable=false, options={"default"="1"})
     */
    private $newActivity = true;

    use TimestampableEntity;
}
