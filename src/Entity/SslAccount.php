<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SslAccounts
 *
 * @ORM\Table(name="ssl_accounts", indexes={@ORM\Index(name="ssl_provider_id", columns={"ssl_provider_id"})})
 * @ORM\Entity
 */
class SslAccount
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
     * @ORM\Column(name="owner_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $ownerId;

    /**
     * @var int
     *
     * @ORM\Column(name="ssl_provider_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $sslProviderId;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=false)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="reseller", type="boolean", nullable=false)
     */
    private $reseller = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="reseller_id", type="string", length=100, nullable=false)
     */
    private $resellerId;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=0, nullable=false)
     */
    private $notes;

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
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;


}
