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
     * @var ApiRegistrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     * @ORM\JoinColumn(name="api_registrar_id", referencedColumnName="id")
     */
    private $apiRegistrar = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="domain_count", type="integer", nullable=false)
     */
    private $domainCount = '0';

    /**
     * @var Owner
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner = '0';

    /**
     * @var Registrar
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar = '0';

    /**
     * @var RegistrarAccount
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account = '0';

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
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;


}
