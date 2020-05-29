<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueueList
 *
 * @ORM\Table(name="domain_queue_list")
 * @ORM\Entity
 */
class DomainQueueList
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
     * @ORM\Column(name="api_registrar_id", type="smallint", nullable=false)
     */
    private $apiRegistrarId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="domain_count", type="integer", nullable=false)
     */
    private $domainCount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $ownerId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="registrar_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $registrarId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $accountId = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="processing", type="boolean", nullable=false)
     */
    private $processing = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="ready_to_import", type="boolean", nullable=false)
     */
    private $readyToImport = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private $finished = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="copied_to_history", type="boolean", nullable=false)
     */
    private $copiedToHistory = '0';

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


}
