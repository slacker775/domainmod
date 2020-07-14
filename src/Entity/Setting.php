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
     * @var string
     *
     * @ORM\Column(name="full_url", type="string", length=100, nullable=false, options={"default"="'http://'"})
     */
    private $fullUrl = '\'http://\'';

    /**
     *
     * @var string
     *
     * @ORM\Column(name="db_version", type="string", length=12, nullable=false)
     */
    private $dbVersion;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="upgrade_available", type="boolean", nullable=false)
     */
    private $upgradeAvailable;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=100, nullable=false)
     */
    private $emailAddress;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="large_mode", type="boolean", nullable=false)
     */
    private $largeMode;

    /**
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="default_category_domains", referencedColumnName="id")
     */
    private $defaultCategoryDomains;

    /**
     *
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="default_category_ssl", referencedColumnName="id")
     */
    private $defaultCategorySsl;

    /**
     *
     * @var Dns
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Dns")
     * @ORM\JoinColumn(name="default_dns", referencedColumnName="id")
     */
    private $defaultDns;

    /**
     *
     * @var Hosting
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting")
     * @ORM\JoinColumn(name="default_host", referencedColumnName="id")
     */
    private $defaultHost;

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     * @ORM\JoinColumn(name="default_ip_address_domains", referencedColumnName="id")
     */
    private $defaultIpAddressDomains;

    /**
     *
     * @var IpAddress
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\IpAddress")
     * @ORM\JoinColumn(name="default_ip_address_ssl", referencedColumnName="id")
     */
    private $defaultIpAddressSsl;

    /**
     *
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="default_owner_domains", referencedColumnName="id")
     */
    private $defaultOwnerDomains;

    /**
     *
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Owner")
     * @ORM\JoinColumn(name="default_owner_ssl", referencedColumnName="id")
     */
    private $defaultOwnerSsl;

    /**
     *
     * @var Registrar
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Registrar")
     * @ORM\JoinColumn(name="default_registrar", referencedColumnName="id")
     */
    private $defaultRegistrar;

    /**
     *
     * @var RegistrarAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\RegistrarAccount")
     * @ORM\JoinColumn(name="default_registrar_account", referencedColumnName="id")
     */
    private $defaultRegistrarAccount;

    /**
     *
     * @var SslAccount
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslAccount")
     * @ORM\JoinColumn(name="default_ssl_provider_account", referencedColumnName="id")
     */
    private $defaultSslProviderAccount;

    /**
     *
     * @var SslCertType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslCertType")
     * @ORM\JoinColumn(name="default_ssl_type", referencedColumnName="id")
     */
    private $defaultSslType;

    /**
     *
     * @var SslProvider
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SslProvider")
     * @ORM\JoinColumn(name="default_ssl_provider", referencedColumnName="id")
     */
    private $defaultSslProvider;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="expiration_days", type="integer", nullable=false, options={"default"="60"})
     */
    private $expirationDays;

    /**
     *
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="email_signature", referencedColumnName="id")
     */
    private $emailSignature;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="currency_converter", type="string", length=10, nullable=false, options={"default"="'era'"})
     */
    private $currencyConverter;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="use_smtp", type="boolean", nullable=false)
     */
    private $useSmtp;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="smtp_server", type="string", length=255, nullable=true)
     */
    private $smtpServer;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="smtp_protocol", type="string", length=3, nullable=true, options={"default"="'tls'"})
     */
    private $smtpProtocol;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="smtp_port", type="string", length=5, nullable=true, options={"default"=587})
     */
    private $smtpPort;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="smtp_email_address", type="string", length=100, nullable=true)
     */
    private $smtpEmailAddress;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="smtp_username", type="string", length=100, nullable=true)
     */
    private $smtpUsername;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="smtp_password", type="string", length=255, nullable=true)
     */
    private $smtpPassword;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="debug_mode", type="boolean", nullable=false)
     */
    private $debugMode;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="local_php_log", type="boolean", nullable=false)
     */
    private $localPhpLog;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->upgradeAvailable = false;
        $this->largeMode = false;
        $this->expirationDays = 60;
        $this->emailSignature = 1;
        $this->currencyConverter = 'era';
        $this->useSmtp = false;
        $this->smtpProtocl = 'tls';
        $this->smtpPort = '587';
        $this->debugMode = false;
        $this->localPhpLog = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullUrl(): string
    {
        return $this->fullUrl;
    }

    public function isLargeMode(): bool
    {
        return $this->largeMode;
    }

    public function getEmailSignature(): User
    {
        return $this->emailSignature;
    }

    public function getCurrencyConverter(): string
    {
        return $this->currencyConverter;
    }

    public function isUseSmtp(): bool
    {
        return $this->useSmtp;
    }

    public function getSmtpServer(): ?string
    {
        return $this->smtpServer;
    }

    public function getSmtpProtocol(): ?string
    {
        return $this->smtpProtocol;
    }

    public function getSmtpPort(): ?string
    {
        return $this->smtpPort;
    }

    public function getSmtpEmailAddress(): ?string
    {
        return $this->smtpEmailAddress;
    }

    public function getSmtpUsername(): ?string
    {
        return $this->smtpUsername;
    }

    public function getSmtpPassword(): ?string
    {
        return $this->smtpPassword;
    }

    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }

    public function isLocalPhpLog(): bool
    {
        return $this->localPhpLog;
    }

    public function setLargeMode(bool $largeMode): self
    {
        $this->largeMode = $largeMode;
        return $this;
    }

    public function setEmailSignature(User $emailSignature): self
    {
        $this->emailSignature = $emailSignature;
        return $this;
    }

    public function setCurrencyConverter(string $currencyConverter): self
    {
        $this->currencyConverter = $currencyConverter;
        return $this;
    }

    public function setUseSmtp(bool $useSmtp): self
    {
        $this->useSmtp = $useSmtp;
        return $this;
    }

    public function setSmtpServer(string $smtpServer): self
    {
        $this->smtpServer = $smtpServer;
        return $this;
    }

    public function setSmtpProtocol(string $smtpProtocol): self
    {
        $this->smtpProtocol = $smtpProtocol;
        return $this;
    }

    public function setSmtpPort(string $smtpPort): self
    {
        $this->smtpPort = $smtpPort;
        return $this;
    }

    public function setSmtpEmailAddress(string $smtpEmailAddress): self
    {
        $this->smtpEmailAddress = $smtpEmailAddress;
        return $this;
    }

    public function setSmtpUsername(string $smtpUsername): self
    {
        $this->smtpUsername = $smtpUsername;
        return $this;
    }

    public function setSmtpPassword(string $smtpPassword): self
    {
        $this->smtpPassword = $smtpPassword;
        return $this;
    }

    public function setDebugMode(bool $debugMode): self
    {
        $this->debugMode = $debugMode;
        return $this;
    }

    public function setLocalPhpLog(bool $localPhpLog): self
    {
        $this->localPhpLog = $localPhpLog;
        return $this;
    }

    public function getDbVersion(): string
    {
        return $this->dbVersion;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setFullUrl(string $fullUrl): self
    {
        $this->fullUrl = $fullUrl;
        return $this;
    }

    public function setDbVersion(string $dbVersion): self
    {
        $this->dbVersion = $dbVersion;
        return $this;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getDefaultRegistrar(): ?Registrar
    {
        return $this->defaultRegistrar;
    }

    public function setDefaultRegistrar(Registrar $defaultRegistrar): self
    {
        $this->defaultRegistrar = $defaultRegistrar;
        return $this;
    }

    public function getDefaultOwnerDomains(): ?Owner
    {
        return $this->defaultOwnerDomains;
    }

    public function getDefaultOwnerSsl(): ?Owner
    {
        return $this->defaultOwnerSsl;
    }

    public function setDefaultOwnerDomains(Owner $defaultOwnerDomains)
    {
        $this->defaultOwnerDomains = $defaultOwnerDomains;
        return $this;
    }

    public function setDefaultOwnerSsl(Owner $defaultOwnerSsl)
    {
        $this->defaultOwnerSsl = $defaultOwnerSsl;
        return $this;
    }

    public function getDefaultCategoryDomains(): ?Category
    {
        return $this->defaultCategoryDomains;
    }

    public function getDefaultCategorySsl(): ?Category
    {
        return $this->defaultCategorySsl;
    }

    public function getDefaultDns(): ?Dns
    {
        return $this->defaultDns;
    }

    public function getDefaultHost(): ?Hosting
    {
        return $this->defaultHost;
    }

    public function getDefaultIpAddressDomains(): ?IpAddress
    {
        return $this->defaultIpAddressDomains;
    }

    public function getDefaultIpAddressSsl(): ?IpAddress
    {
        return $this->defaultIpAddressSsl;
    }

    public function getDefaultRegistrarAccount(): ?RegistrarAccount
    {
        return $this->defaultRegistrarAccount;
    }

    public function getDefaultSslProviderAccount(): ?SslAccount
    {
        return $this->defaultSslProviderAccount;
    }

    public function getDefaultSslType(): ?SslCertType
    {
        return $this->defaultSslType;
    }

    public function getDefaultSslProvider(): ?SslProvider
    {
        return $this->defaultSslProvider;
    }

    public function getExpirationDays(): int
    {
        return $this->expirationDays;
    }

    public function setDefaultCategoryDomains(Category $defaultCategoryDomains): self
    {
        $this->defaultCategoryDomains = $defaultCategoryDomains;
        return $this;
    }

    public function setDefaultCategorySsl(Category $defaultCategorySsl): self
    {
        $this->defaultCategorySsl = $defaultCategorySsl;
        return $this;
    }

    public function setDefaultDns(Dns $defaultDns): self
    {
        $this->defaultDns = $defaultDns;
        return $this;
    }

    public function setDefaultHost(Hosting $defaultHost): self
    {
        $this->defaultHost = $defaultHost;
        return $this;
    }

    public function setDefaultIpAddressDomains(IpAddress $defaultIpAddressDomains): self
    {
        $this->defaultIpAddressDomains = $defaultIpAddressDomains;
        return $this;
    }

    public function setDefaultIpAddressSsl(IpAddress $defaultIpAddressSsl): self
    {
        $this->defaultIpAddressSsl = $defaultIpAddressSsl;
        return $this;
    }

    public function setDefaultRegistrarAccount(RegistrarAccount $defaultRegistrarAccount): self
    {
        $this->defaultRegistrarAccount = $defaultRegistrarAccount;
        return $this;
    }

    public function setDefaultSslProviderAccount(SslAccount $defaultSslProviderAccount): self
    {
        $this->defaultSslProviderAccount = $defaultSslProviderAccount;
        return $this;
    }

    public function setDefaultSslType(SslCertType $defaultSslType): self
    {
        $this->defaultSslType = $defaultSslType;
        return $this;
    }

    public function setDefaultSslProvider(SslProvider $defaultSslProvider): self
    {
        $this->defaultSslProvider = $defaultSslProvider;
        return $this;
    }

    public function setExpirationDays(int $expirationDays): self
    {
        $this->expirationDays = $expirationDays;
        return $this;
    }
}
