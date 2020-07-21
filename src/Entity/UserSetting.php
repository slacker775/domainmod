<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UserSettings
 *
 * @ORM\Entity
 */
class UserSetting
{
    use EntityIdTrait;

    /**
     *
     * @var User
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="settings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="default_currency", type="string", length=3, nullable=false)
     */
    private $defaultCurrency;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="default_timezone", type="string", length=50, nullable=false, options={"default"="'Canada/Pacific'"})
     */
    private $defaultTimezone = '\'Canada/Pacific\'';

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Registrar")
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
     * @var bool
     *
     * @ORM\Column(name="expiration_emails", type="boolean", nullable=false)
     */
    private $expirationEmails = '0';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="number_of_domains", type="integer", nullable=false, options={"default"="50"})
     */
    private $numberOfDomains = '50';

    /**
     *
     * @var int
     *
     * @ORM\Column(name="number_of_ssl_certs", type="integer", nullable=false, options={"default"="50"})
     */
    private $numberOfSslCerts = '50';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_owner", type="boolean", nullable=false)
     */
    private $displayDomainOwner = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_registrar", type="boolean", nullable=false)
     */
    private $displayDomainRegistrar = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_account", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainAccount = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_expiry_date", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainExpiryDate = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_category", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainCategory = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_dns", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainDns = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_host", type="boolean", nullable=false)
     */
    private $displayDomainHost = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_ip", type="boolean", nullable=false)
     */
    private $displayDomainIp = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_tld", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainTld = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_domain_fee", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDomainFee = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_owner", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslOwner = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_provider", type="boolean", nullable=false)
     */
    private $displaySslProvider = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_account", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslAccount = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_domain", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslDomain = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_type", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslType = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_expiry_date", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displaySslExpiryDate = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_ip", type="boolean", nullable=false)
     */
    private $displaySslIp = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_category", type="boolean", nullable=false)
     */
    private $displaySslCategory = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_ssl_fee", type="boolean", nullable=false)
     */
    private $displaySslFee = '0';

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_inactive_assets", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayInactiveAssets = true;

    /**
     *
     * @var bool
     *
     * @ORM\Column(name="display_dw_intro_page", type="boolean", nullable=false, options={"default"="1"})
     */
    private $displayDwIntroPage = true;

    use TimestampableEntity;

    public function __construct()
    {
        $this->generateId();
        $this->defaultCurrency = 'USD';
        $this->defaultTimezone = 'America/New_York';
        $this->defaultCategoryDomains = null;
        $this->defaultCategorySsl = null;
        $this->defaultDns = null;
        $this->defaultHost = null;
        $this->defaultIpAddressDomains = null;
        $this->defaultIpAddressSsl = null;
        $this->defaultOwnerDomains = null;
        $this->defaultOwnerSsl = null;
        $this->defaultRegistrar = null;
        $this->defaultRegistrarAccount = null;
        $this->defaultSslProviderAccount = null;
        $this->defaultSslType = null;
        $this->defaultSslProvider = null;
        $this->expirationEmails = false;
        $this->numberOfDomains = '50';
        $this->numberOfSslCerts = '50';
        $this->displayDomainOwner = false;
        $this->displayDomainRegistrar = false;
        $this->displayDomainAccount = true;
        $this->displayDomainExpiryDate = true;
        $this->displayDomainCategory = true;
        $this->displayDomainDns = true;
        $this->displayDomainHost = false;
        $this->displayDomainIp = false;
        $this->displayDomainTld = true;
        $this->displayDomainFee = true;
        $this->displaySslOwner = true;
        $this->displaySslProvider = false;
        $this->displaySslAccount = true;
        $this->displaySslDomain = true;
        $this->displaySslType = true;
        $this->displaySslExpiryDate = true;
        $this->displaySslIp = false;
        $this->displaySslCategory = false;
        $this->displaySslFee = false;
        $this->displayInactiveAssets = true;
        $this->displayDwIntroPage = true;
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

    public function getExpirationEmails(): bool
    {
        return $this->expirationEmails;
    }

    public function setExpirationEmails(bool $expirationEmails = true): self
    {
        $this->expirationEmails = $expirationEmails;
        return $this;
    }

    public function getDefaultCurrency(): string
    {
        return $this->defaultCurrency;
    }

    public function setDefaultCurrency(string $defaultCurrency): self
    {
        $this->defaultCurrency = $defaultCurrency;
        return $this;
    }

    public function getDefaultTimezone(): string
    {
        return $this->defaultTimezone;
    }

    public function setDefaultTimezone(string $defaultTimezone): self
    {
        $this->defaultTimezone = $defaultTimezone;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getDefaultCategoryDomains(): ?Category
    {
        return $this->defaultCategoryDomains;
    }

    public function setDefaultCategoryDomains(Category $defaultCategoryDomains): self
    {
        $this->defaultCategoryDomains = $defaultCategoryDomains;
        return $this;
    }

    public function getDefaultCategorySsl(): ?Category
    {
        return $this->defaultCategorySsl;
    }

    public function setDefaultCategorySsl(Category $defaultCategorySsl): self
    {
        $this->defaultCategorySsl = $defaultCategorySsl;
        return $this;
    }

    public function getDefaultDns(): ?Dns
    {
        return $this->defaultDns;
    }

    public function setDefaultDns(Dns $defaultDns): self
    {
        $this->defaultDns = $defaultDns;
        return $this;
    }

    public function getDefaultHost(): ?Hosting
    {
        return $this->defaultHost;
    }

    public function setDefaultHost(Hosting $defaultHost): self
    {
        $this->defaultHost = $defaultHost;
        return $this;
    }

    public function getDefaultIpAddressDomains(): ?IpAddress
    {
        return $this->defaultIpAddressDomains;
    }

    public function setDefaultIpAddressDomains(IpAddress $defaultIpAddressDomains): self
    {
        $this->defaultIpAddressDomains = $defaultIpAddressDomains;
        return $this;
    }

    public function getDefaultIpAddressSsl(): ?IpAddress
    {
        return $this->defaultIpAddressSsl;
    }

    public function setDefaultIpAddressSsl(IpAddress $defaultIpAddressSsl): self
    {
        $this->defaultIpAddressSsl = $defaultIpAddressSsl;
        return $this;
    }

    public function getDefaultOwnerDomains(): ?Owner
    {
        return $this->defaultOwnerDomains;
    }

    public function setDefaultOwnerDomains(Owner $defaultOwnerDomains): self
    {
        $this->defaultOwnerDomains = $defaultOwnerDomains;
        return $this;
    }

    public function getDefaultOwnerSsl(): ?Owner
    {
        return $this->defaultOwnerSsl;
    }

    public function setDefaultOwnerSsl(Owner $defaultOwnerSsl): self
    {
        $this->defaultOwnerSsl = $defaultOwnerSsl;
        return $this;
    }

    public function getDefaultRegistrarAccount(): ?RegistrarAccount
    {
        return $this->defaultRegistrarAccount;
    }

    public function setDefaultRegistrarAccount(RegistrarAccount $defaultRegistrarAccount): self
    {
        $this->defaultRegistrarAccount = $defaultRegistrarAccount;
        return $this;
    }

    public function getDefaultSslProviderAccount(): ?SslAccount
    {
        return $this->defaultSslProviderAccount;
    }

    public function setDefaultSslProviderAccount(SslAccount $defaultSslProviderAccount): self
    {
        $this->defaultSslProviderAccount = $defaultSslProviderAccount;
        return $this;
    }

    public function getDefaultSslType(): ?SslCertType
    {
        return $this->defaultSslType;
    }

    public function setDefaultSslType(SslCertType $defaultSslType): self
    {
        $this->defaultSslType = $defaultSslType;
        return $this;
    }

    public function getDefaultSslProvider(): ?SslProvider
    {
        return $this->defaultSslProvider;
    }

    public function setDefaultSslProvider(SslProvider $defaultSslProvider): self
    {
        $this->defaultSslProvider = $defaultSslProvider;
        return $this;
    }

    public function isDisplaySslOwner(): bool
    {
        return $this->displaySslOwner;
    }

    public function setDisplaySslOwner(bool $displaySslOwner): bool
    {
        $this->displaySslOwner = $displaySslOwner;
        return $this;
    }

    public function isDisplaySslProvider(): bool
    {
        return $this->displaySslProvider;
    }

    public function setDisplaySslProvider(bool $displaySslProvider): self
    {
        $this->displaySslProvider = $displaySslProvider;
        return $this;
    }

    public function isDisplaySslAccount(): bool
    {
        return $this->displaySslAccount;
    }

    public function setDisplaySslAccount(bool $displaySslAccount): self
    {
        $this->displaySslAccount = $displaySslAccount;
        return $this;
    }

    public function isDisplaySslDomain(): bool
    {
        return $this->displaySslDomain;
    }

    public function setDisplaySslDomain(bool $displaySslDomain): self
    {
        $this->displaySslDomain = $displaySslDomain;
        return $this;
    }

    public function isDisplaySslType(): bool
    {
        return $this->displaySslType;
    }

    public function setDisplaySslType(bool $displaySslType): self
    {
        $this->displaySslType = $displaySslType;
        return $this;
    }

    public function isDisplaySslExpiryDate(): bool
    {
        return $this->displaySslExpiryDate;
    }

    public function setDisplaySslExpiryDate(bool $displaySslExpiryDate): self
    {
        $this->displaySslExpiryDate = $displaySslExpiryDate;
        return $this;
    }

    public function isDisplaySslIp(): bool
    {
        return $this->displaySslIp;
    }

    public function setDisplaySslIp(bool $displaySslIp): self
    {
        $this->displaySslIp = $displaySslIp;
        return $this;
    }

    public function isDisplaySslCategory(): bool
    {
        return $this->displaySslCategory;
    }

    public function setDisplaySslCategory(bool $displaySslCategory): self
    {
        $this->displaySslCategory = $displaySslCategory;
        return $this;
    }

    public function isDisplaySslFee(): bool
    {
        return $this->displaySslFee;
    }

    public function setDisplaySslFee(bool $displaySslFee): self
    {
        $this->displaySslFee = $displaySslFee;
        return $this;
    }

    public function isDisplayInactiveAssets(): bool
    {
        return $this->displayInactiveAssets;
    }

    public function setDisplayInactiveAssets(bool $displayInactiveAssets = true): self
    {
        $this->displayInactiveAssets = $displayInactiveAssets;
        return $this;
    }

    public function getNumberOfDomains(): int
    {
        return $this->numberOfDomains;
    }

    public function setNumberOfDomains(int $numberOfDomains): self
    {
        $this->numberOfDomains = $numberOfDomains;
        return $this;
    }

    public function getNumberOfSslCerts(): int
    {
        return $this->numberOfSslCerts;
    }

    public function setNumberOfSslCerts(int $numberOfSslCerts): self
    {
        $this->numberOfSslCerts = $numberOfSslCerts;
        return $this;
    }

    public function isDisplayDomainOwner(): bool
    {
        return $this->displayDomainOwner;
    }

    public function setDisplayDomainOwner(bool $displayDomainOwner): self
    {
        $this->displayDomainOwner = $displayDomainOwner;
        return $this;
    }

    public function isDisplayDomainRegistrar(): bool
    {
        return $this->displayDomainRegistrar;
    }

    public function setDisplayDomainRegistrar(bool $displayDomainRegistrar): self
    {
        $this->displayDomainRegistrar = $displayDomainRegistrar;
        return $this;
    }

    public function isDisplayDomainAccount(): bool
    {
        return $this->displayDomainAccount;
    }

    public function setDisplayDomainAccount(bool $displayDomainAccount): self
    {
        $this->displayDomainAccount = $displayDomainAccount;
        return $this;
    }

    public function isDisplayDomainExpiryDate(): bool
    {
        return $this->displayDomainExpiryDate;
    }

    public function setDisplayDomainExpiryDate(bool $displayDomainExpiryDate): self
    {
        $this->displayDomainExpiryDate = $displayDomainExpiryDate;
        return $this;
    }

    public function isDisplayDomainCategory(): bool
    {
        return $this->displayDomainCategory;
    }

    public function setDisplayDomainCategory(bool $displayDomainCategory): self
    {
        $this->displayDomainCategory = $displayDomainCategory;
        return $this;
    }

    public function isDisplayDomainDns(): bool
    {
        return $this->displayDomainDns;
    }

    public function setDisplayDomainDns(bool $displayDomainDns): self
    {
        $this->displayDomainDns = $displayDomainDns;
        return $this;
    }

    public function isDisplayDomainHost(): bool
    {
        return $this->displayDomainHost;
    }

    public function setDisplayDomainHost(bool $displayDomainHost): self
    {
        $this->displayDomainHost = $displayDomainHost;
        return $this;
    }

    public function isDisplayDomainIp(): bool
    {
        return $this->displayDomainIp;
    }

    public function setDisplayDomainIp(bool $displayDomainIp): self
    {
        $this->displayDomainIp = $displayDomainIp;
        return $this;
    }

    public function isDisplayDomainTld(): bool
    {
        return $this->displayDomainTld;
    }

    public function setDisplayDomainTld(bool $displayDomainTld): self
    {
        $this->displayDomainTld = $displayDomainTld;
        return $this;
    }

    public function isDisplayDomainFee(): bool
    {
        return $this->displayDomainFee;
    }

    public function setDisplayDomainFee(bool $displayDomainFee): self
    {
        $this->displayDomainFee = $displayDomainFee;
        return $this;
    }

    public function isDisplayDwIntroPage(): bool
    {
        return $this->displayDwIntroPage;
    }

    public function setDisplayDwIntroPage(bool $displayDwIntroPage): self
    {
        $this->displayDwIntroPage = $displayDwIntroPage;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'defaultCategoryDomains' => $this->defaultCategoryDomains,
            'defaultCategorySsl' => $this->defaultCategorySsl,
            'defaultDns' => $this->defaultDns,
            'defaultHost' => $this->defaultHost,
            'defaultIpAddressDomains' => $this->defaultIpAddressDomains,
            'defaultIpAddressSsl' => $this->defaultIpAddressSsl,
            'defaultOwnerDomains' => $this->defaultOwnerDomains,
            'defaultOwnerSsl' => $this->defaultOwnerSsl,
            'defaultRegistrar' => $this->defaultRegistrar,
            'defaultRegistrarAccount' => $this->defaultRegistrarAccount,
            'defaultSslProviderAccount' => $this->defaultSslProviderAccount,
            'defaultSslType' => $this->defaultSslType,
            'defaultSslProvider' => $this->defaultSslProvider,
            'defaultCurrency' => $this->defaultCurrency,
            'defaultTimezone' => $this->defaultTimezone,
            'expirationEmails' => $this->expirationEmails,
            'numberOfDomains' => $this->numberOfDomains,
            'numberOfSslCerts' => $this->numberOfSslCerts,
            'displayDomainOwner' => $this->displayDomainOwner,
            'displayDomainRegistrar' => $this->displayDomainRegistrar,
            'displayDomainAccount' => $this->displayDomainAccount,
            'displayDomainExpiryDate' => $this->displayDomainExpiryDate,
            'displayDomainCategory' => $this->displayDomainCategory,
            'displayDomainDns' => $this->displayDomainDns,
            'displayDomainHost' => $this->displayDomainHost,
            'displayDomainIp' => $this->displayDomainIp,
            'displayDomainTld' => $this->displayDomainTld,
            'displayDomainFee' => $this->displayDomainFee,
            'displaySslOwner' => $this->displaySslOwner,
            'displaySslProvider' => $this->displaySslProvider,
            'displaySslAccount' => $this->displaySslAccount,
            'displaySslDomain' => $this->displaySslDomain,
            'displaySslType' => $this->displaySslType,
            'displaySslExpiryDate' => $this->displaySslExpiryDate,
            'displaySslIp' => $this->displaySslIp,
            'displaySslCategory' => $this->displaySslCategory,
            'displaySslFee' => $this->displaySslFee,
            'displayInactiveAssets' => $this->displayInactiveAssets,
            'displayDwIntroPage' => $this->displayDwIntroPage
        ];
    }
}
