<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSettings
 *
 * @ORM\Table(name="user_settings")
 * @ORM\Entity
 */
class UserSetting
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
     * @ORM\Column(name="user_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="default_currency", type="string", length=3, nullable=false)
     */
    private $defaultCurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="default_timezone", type="string", length=50, nullable=false, options={"default"="'Canada/Pacific'"})
     */
    private $defaultTimezone = '\'Canada/Pacific\'';

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
     * @var bool
     *
     * @ORM\Column(name="expiration_emails", type="boolean", nullable=false)
     */
    private $expirationEmails = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="number_of_domains", type="integer", nullable=false, options={"default"="50"})
     */
    private $numberOfDomains = '50';

    /**
     * @var int
     *
     * @ORM\Column(name="number_of_ssl_certs", type="integer", nullable=false, options={"default"="50"})
     */
    private $numberOfSslCerts = '50';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_owner", type="boolean", nullable=false)
     */
    private $displayDomainOwner = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_registrar", type="boolean", nullable=false)
     */
    private $displayDomainRegistrar = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_account", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainAccount = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_expiry_date", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainExpiryDate = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_category", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainCategory = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_dns", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainDns = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_host", type="boolean", nullable=false)
     */
    private $displayDomainHost = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_ip", type="boolean", nullable=false)
     */
    private $displayDomainIp = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_tld", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainTld = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_domain_fee", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainFee = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_owner", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslOwner = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_provider", type="boolean", nullable=false)
     */
    private $displaySslProvider = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_account", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslAccount = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_domain", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslDomain = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_type", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslType = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_expiry_date", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslExpiryDate = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_ip", type="boolean", nullable=false)
     */
    private $displaySslIp = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_category", type="boolean", nullable=false)
     */
    private $displaySslCategory = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_ssl_fee", type="boolean", nullable=false)
     */
    private $displaySslFee = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="display_inactive_assets", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayInactiveAssets = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_dw_intro_page", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDwIntroPage = true;

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
