<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueue
 *
 * @ORM\Table(name="domain_queue")
 * @ORM\Entity
 */
class DomainQueue
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
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId = '0';

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
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain;

    /**
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private $tld;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=false, options={"default"="'1970-01-01'"})
     */
    private $expiryDate = '\'1970-01-01\'';

    /**
     * @var int
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $catId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="dns_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $dnsId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ip_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $ipId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="hosting_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $hostingId = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="autorenew", type="boolean", nullable=false)
     */
    private $autorenew = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="privacy", type="boolean", nullable=false)
     */
    private $privacy = '0';

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
     * @ORM\Column(name="already_in_domains", type="boolean", nullable=false)
     */
    private $alreadyInDomains = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="already_in_queue", type="boolean", nullable=false)
     */
    private $alreadyInQueue = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="invalid_domain", type="boolean", nullable=false)
     */
    private $invalidDomain = '0';

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
