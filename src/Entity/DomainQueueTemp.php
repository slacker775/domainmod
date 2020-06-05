<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainQueueTemp
 *
 * @ORM\Table(name="domain_queue_temp", indexes={@ORM\Index(name="domain", columns={"domain"})})
 * @ORM\Entity
 */
class DomainQueueTemp
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
     * @ORM\Column(name="account_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="date", nullable=false)
     */
    private $expiryDate = '\'1970-01-01\'';

    /**
     * @var string
     *
     * @ORM\Column(name="ns1", type="string", length=255, nullable=false)
     */
    private $ns1;

    /**
     * @var string
     *
     * @ORM\Column(name="ns2", type="string", length=255, nullable=false)
     */
    private $ns2;

    /**
     * @var string
     *
     * @ORM\Column(name="ns3", type="string", length=255, nullable=false)
     */
    private $ns3;

    /**
     * @var string
     *
     * @ORM\Column(name="ns4", type="string", length=255, nullable=false)
     */
    private $ns4;

    /**
     * @var string
     *
     * @ORM\Column(name="ns5", type="string", length=255, nullable=false)
     */
    private $ns5;

    /**
     * @var string
     *
     * @ORM\Column(name="ns6", type="string", length=255, nullable=false)
     */
    private $ns6;

    /**
     * @var string
     *
     * @ORM\Column(name="ns7", type="string", length=255, nullable=false)
     */
    private $ns7;

    /**
     * @var string
     *
     * @ORM\Column(name="ns8", type="string", length=255, nullable=false)
     */
    private $ns8;

    /**
     * @var string
     *
     * @ORM\Column(name="ns9", type="string", length=255, nullable=false)
     */
    private $ns9;

    /**
     * @var string
     *
     * @ORM\Column(name="ns10", type="string", length=255, nullable=false)
     */
    private $ns10;

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


}
