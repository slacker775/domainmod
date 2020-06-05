<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueueListHistory
 *
 * @ORM\Table(name="domain_queue_list_history")
 * @ORM\Entity
 */
class DomainQueueListHistory
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


}
