<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DwServers
 *
 * @ORM\Table(name="dw_servers")
 * @ORM\Entity
 */
class DwServer
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
     * @ORM\Column(name="host", type="string", length=100, nullable=false)
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="protocol", type="string", length=5, nullable=false)
     */
    private $protocol;

    /**
     * @var int
     *
     * @ORM\Column(name="port", type="integer", nullable=false)
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token", type="string", length=255, nullable=false)
     */
    private $apiToken;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="text", length=0, nullable=false)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

    /**
     * @var int
     *
     * @ORM\Column(name="dw_accounts", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $dwAccounts;

    /**
     * @var int
     *
     * @ORM\Column(name="dw_dns_zones", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $dwDnsZones;

    /**
     * @var int
     *
     * @ORM\Column(name="dw_dns_records", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $dwDnsRecords;

    /**
     * @var bool
     *
     * @ORM\Column(name="build_status", type="boolean", nullable=false)
     */
    private $buildStatus = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="build_start_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $buildStartTime = '\'1970-01-01 00:00:00\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="build_end_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $buildEndTime = '\'1970-01-01 00:00:00\'';

    /**
     * @var int
     *
     * @ORM\Column(name="build_time", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $buildTime = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="has_ever_been_built", type="boolean", nullable=false)
     */
    private $hasEverBeenBuilt = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="build_status_overall", type="boolean", nullable=false)
     */
    private $buildStatusOverall = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="build_start_time_overall", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $buildStartTimeOverall = '\'1970-01-01 00:00:00\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="build_end_time_overall", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $buildEndTimeOverall = '\'1970-01-01 00:00:00\'';

    /**
     * @var int
     *
     * @ORM\Column(name="build_time_overall", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $buildTimeOverall = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="has_ever_been_built_overall", type="boolean", nullable=false)
     */
    private $hasEverBeenBuiltOverall = '0';

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
