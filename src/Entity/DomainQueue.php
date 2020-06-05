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
     * @var ApiRegistrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     * @ORM\JoinColumn(name="api_registrar_id", referencedColumnName="id")
     */
    private $apiRegistrar;

    /**
     *
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiRegistrar")
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     */
    private $domain = '0';

    /**
     *
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner = '0';

    /**
     *
     * @var Registrar
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar")
     * @ORM\JoinColumn(name="registrar_id", referencedColumnName="id")
     */
    private $registrar = '0';

    /**
     *
     * @var RegistrarAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount")
     * @ORM\JoinColumn(name="account_id",referencedColumnName="id")
     */
    private $account = '0';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domainName;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private $tld;

    /**
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=false)
     */
    private $expiryDate = '\'1970-01-01\'';

    /**
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="id")
     */
    private $category = '0';

    /**
     *
     * @var Dns
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Dns")
     * @ORM\JoinColumn(name="dns_id", referencedColumnName="id")
     */
    private $dns = '0';

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     * @ORM\JoinColumn(name="ip_id", referencedColumnName="id")
     */
    private $ip = '0';

    /**
     *
     * @var Hosting
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting")
     * @ORM\JoinColumn(name="hosting_id", referencedColumnName="id")
     */
    private $hosting = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="autorenew", type="boolean", nullable=false)
     */
    private $autorenew = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="privacy", type="boolean", nullable=false)
     */
    private $privacy = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="processing", type="boolean", nullable=false)
     */
    private $processing = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="ready_to_import", type="boolean", nullable=false)
     */
    private $readyToImport = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private $finished = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="already_in_domains", type="boolean", nullable=false)
     */
    private $alreadyInDomains = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="already_in_queue", type="boolean", nullable=false)
     */
    private $alreadyInQueue = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="invalid_domain", type="boolean", nullable=false)
     */
    private $invalidDomain = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="copied_to_history", type="boolean", nullable=false)
     */
    private $copiedToHistory = '0';

    /**
     *
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
