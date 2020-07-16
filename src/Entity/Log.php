<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Log
 *
 * @ORM\Entity
 */
class Log
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userId = '0';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=255, nullable=false)
     */
    private $area;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=9, nullable=false)
     */
    private $level;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=0, nullable=false)
     */
    private $message;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="extra", type="text", length=0, nullable=false)
     */
    private $extra;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="url", type="text", length=0, nullable=false)
     */
    private $url;

    use TimestampableEntity;
}
