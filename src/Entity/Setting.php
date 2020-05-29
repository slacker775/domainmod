<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 */
class Setting
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
     * @ORM\Column(name="full_url", type="string", length=100, nullable=false, options={"default"="'http://'"})
     */
    private $fullUrl = '\'http://\'';

    /**
     * @var string
     *
     * @ORM\Column(name="db_version", type="string", length=12, nullable=false)
     */
    private $dbVersion;

    /**
     * @var bool
     *
     * @ORM\Column(name="upgrade_available", type="boolean", nullable=false)
     */
    private $upgradeAvailable = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=false)
     */
    private $emailAddress;

    /**
     * @var bool
     *
     * @ORM\Column(name="large_mode", type="boolean", nullable=false)
     */
    private $largeMode = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_category_domains", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultCategoryDomains = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_category_ssl", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultCategorySsl = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_dns", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultDns = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_host", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultHost = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_ip_address_domains", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultIpAddressDomains = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_ip_address_ssl", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultIpAddressSsl = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_owner_domains", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultOwnerDomains = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_owner_ssl", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultOwnerSsl = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_registrar", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultRegistrar = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_registrar_account", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultRegistrarAccount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_ssl_provider_account", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultSslProviderAccount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_ssl_type", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultSslType = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default_ssl_provider", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $defaultSslProvider = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="expiration_days", type="integer", nullable=false, options={"default"="60"})
     */
    private $expirationDays = '60';

    /**
     * @var int
     *
     * @ORM\Column(name="email_signature", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $emailSignature = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="currency_converter", type="string", length=10, nullable=false, options={"default"="'era'"})
     */
    private $currencyConverter = '\'era\'';

    /**
     * @var bool
     *
     * @ORM\Column(name="use_smtp", type="boolean", nullable=false)
     */
    private $useSmtp = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="smtp_server", type="string", length=255, nullable=false)
     */
    private $smtpServer;

    /**
     * @var string
     *
     * @ORM\Column(name="smtp_protocol", type="string", length=3, nullable=false, options={"default"="'tls'"})
     */
    private $smtpProtocol = '\'tls\'';

    /**
     * @var string
     *
     * @ORM\Column(name="smtp_port", type="string", length=5, nullable=false, options={"default"="'587'"})
     */
    private $smtpPort = '\'587\'';

    /**
     * @var string
     *
     * @ORM\Column(name="smtp_email_address", type="string", length=100, nullable=false)
     */
    private $smtpEmailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="smtp_username", type="string", length=100, nullable=false)
     */
    private $smtpUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="smtp_password", type="string", length=255, nullable=false)
     */
    private $smtpPassword;

    /**
     * @var bool
     *
     * @ORM\Column(name="debug_mode", type="boolean", nullable=false)
     */
    private $debugMode = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="local_php_log", type="boolean", nullable=false)
     */
    private $localPhpLog = '0';

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
