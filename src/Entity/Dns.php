<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dns
 *
 * @ORM\Table(name="dns")
 * @ORM\Entity
 */
class Dns
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="dns1", type="string", length=255, nullable=false)
     */
    private $dns1;

    /**
     * @var string
     *
     * @ORM\Column(name="dns2", type="string", length=255, nullable=false)
     */
    private $dns2;

    /**
     * @var string
     *
     * @ORM\Column(name="dns3", type="string", length=255, nullable=false)
     */
    private $dns3;

    /**
     * @var string
     *
     * @ORM\Column(name="dns4", type="string", length=255, nullable=false)
     */
    private $dns4;

    /**
     * @var string
     *
     * @ORM\Column(name="dns5", type="string", length=255, nullable=false)
     */
    private $dns5;

    /**
     * @var string
     *
     * @ORM\Column(name="dns6", type="string", length=255, nullable=false)
     */
    private $dns6;

    /**
     * @var string
     *
     * @ORM\Column(name="dns7", type="string", length=255, nullable=false)
     */
    private $dns7;

    /**
     * @var string
     *
     * @ORM\Column(name="dns8", type="string", length=255, nullable=false)
     */
    private $dns8;

    /**
     * @var string
     *
     * @ORM\Column(name="dns9", type="string", length=255, nullable=false)
     */
    private $dns9;

    /**
     * @var string
     *
     * @ORM\Column(name="dns10", type="string", length=255, nullable=false)
     */
    private $dns10;

    /**
     * @var string
     *
     * @ORM\Column(name="ip1", type="string", length=45, nullable=false)
     */
    private $ip1;

    /**
     * @var string
     *
     * @ORM\Column(name="ip2", type="string", length=45, nullable=false)
     */
    private $ip2;

    /**
     * @var string
     *
     * @ORM\Column(name="ip3", type="string", length=45, nullable=false)
     */
    private $ip3;

    /**
     * @var string
     *
     * @ORM\Column(name="ip4", type="string", length=45, nullable=false)
     */
    private $ip4;

    /**
     * @var string
     *
     * @ORM\Column(name="ip5", type="string", length=45, nullable=false)
     */
    private $ip5;

    /**
     * @var string
     *
     * @ORM\Column(name="ip6", type="string", length=45, nullable=false)
     */
    private $ip6;

    /**
     * @var string
     *
     * @ORM\Column(name="ip7", type="string", length=45, nullable=false)
     */
    private $ip7;

    /**
     * @var string
     *
     * @ORM\Column(name="ip8", type="string", length=45, nullable=false)
     */
    private $ip8;

    /**
     * @var string
     *
     * @ORM\Column(name="ip9", type="string", length=45, nullable=false)
     */
    private $ip9;

    /**
     * @var string
     *
     * @ORM\Column(name="ip10", type="string", length=45, nullable=false)
     */
    private $ip10;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     * @var bool
     *
     * @ORM\Column(name="number_of_servers", type="boolean", nullable=false)
     */
    private $numberOfServers = '0';

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
