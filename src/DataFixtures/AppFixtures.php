<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CreationType;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Hosting;
use App\Entity\Owner;
use App\Entity\CustomFieldType;
use App\Entity\SslCertType;
use App\Entity\Dns;
use App\Entity\IpAddress;
use App\Entity\Setting;
use App\Entity\ApiRegistrar;
use App\Entity\Scheduler;
use Symfony\Component\Intl\Timezones;
use App\Entity\Timezone;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\UserSetting;
use Symfony\Component\Intl\Currencies;
use App\Entity\Currency;

class AppFixtures extends Fixture
{

    public const CREATION_TYPE_INSTALL_REF = 'create-type-install';

    public const ADMIN_USER_REF = 'admin-user';

    public const DEFAULT_OWNER_REF = 'default-owner';

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadCreationTypes($manager);
        $this->loadUsers($manager);
        $this->loadCategories($manager);
        $this->loadHosting($manager);
        $this->loadOwners($manager);
        $this->loadCurrencies($manager);
        $this->loadTimezones($manager);
        $this->loadCustomFieldTypes($manager);
        $this->loadSslCertTypes($manager);
        $this->loadDns($manager);
        $this->loadIpAddresses($manager);
        $this->loadScheduler($manager);
        $this->loadApiRegistrars($manager);
        $this->loadSettings($manager);
        $manager->flush();
    }

    private function loadCreationTypes(ObjectManager $manager)
    {
        $types = [
            'Installation',
            'Manual',
            'Bulk Updater',
            'Manual or Bulk Updater',
            'Queue',
            'Import',
        ];
        foreach ($types as $type) {
            $obj = new CreationType($type);
            $manager->persist($obj);

            if ($type == 'Installation') {
                $this->addReference(self::CREATION_TYPE_INSTALL_REF, $obj);
            }
        }
    }

    private function loadUsers(ObjectManager $manager)
    {
        $obj = new User();
        $obj->setFirstname('Domain')
            ->setLastname('Administrator')
            ->setUsername('admin')
            ->setEmailAddress('admin@example.com')
            ->setAdmin()
            ->setReadOnly(false)
            ->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
            ->setPassword($this->encoder->encodePassword($obj, 'password'));
        $settings = new UserSetting();
        $obj->setSettings($settings);
        $manager->persist($obj);
        $this->addReference(self::ADMIN_USER_REF, $obj);
    }

    private function loadCategories(ObjectManager $manager)
    {
        $obj = Category::create('[no category]', '[no stakeholder]');
        $obj->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
            ->setCreatedBy($this->getReference(self::ADMIN_USER_REF));
        $manager->persist($obj);
    }

    private function loadHosting(ObjectManager $manager)
    {
        $obj = new Hosting();
        $obj->setName('[no hosting]');
        $obj->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
            ->setCreatedBy($this->getReference(self::ADMIN_USER_REF));
        $manager->persist($obj);
    }

    private function loadOwners(ObjectManager $manager)
    {
        $obj = new Owner();
        $obj->setName('[no owner]');
        $obj->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
            ->setCreatedBy($this->getReference(self::ADMIN_USER_REF));
        $manager->persist($obj);
        $this->addReference(self::DEFAULT_OWNER_REF, $obj);
    }

    private function loadCurrencies(ObjectManager $manager)
    {
        $currencies = Currencies::getNames();

        foreach ($currencies as $code => $name) {
            $c = new Currency();
            $c->setName($name)
                ->setCurrency($code)
                ->setSymbol(Currencies::getSymbol($code));
            $manager->persist($c);
        }
    }

    private function loadTimezones(ObjectManager $manager)
    {
        $timezones = Timezones::getNames();
        foreach ($timezones as $tz => $local) {
            $obj = new Timezone();
            $obj->setTimezone($tz);
            $manager->persist($obj);
        }
    }

    private function loadCustomFieldTypes(ObjectManager $manager)
    {
        $types = [
            'Check Box',
            'Text',
            'Text Area',
            'Date',
            'Time Stamp'
        ];

        foreach ($types as $type) {
            $obj = new CustomFieldType($type);
            $manager->persist($obj);
        }
    }

    private function loadSslCertTypes(ObjectManager $manager)
    {
        $types = [
            'Web Server SSL/TLS Certificate',
            'S/MIME and Authentication Certificate',
            'Object Code Signing Certificate',
            'Digital ID'
        ];

        foreach ($types as $type) {
            $obj = new SslCertType($type);
            $obj->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
                ->setCreatedBy($this->getReference(self::ADMIN_USER_REF));
            $manager->persist($obj);
        }
    }

    private function loadDns(ObjectManager $manager)
    {
        $obj = new Dns();
        $obj->setName('[no dns]')
            ->setDns1('ns1.no-dns.com')
            ->setDns2('ns2.no-dns.com');
        $obj->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
            ->setCreatedBy($this->getReference(self::ADMIN_USER_REF));
        $manager->persist($obj);
    }

    private function loadIpAddresses(ObjectManager $manager)
    {
        $obj = new IpAddress();
        $obj->setName('[no ip address]')
            ->setIp('-')
            ->setRdns('-');
        $obj->setCreationType($this->getReference(self::CREATION_TYPE_INSTALL_REF))
            ->setCreatedBy($this->getReference(self::ADMIN_USER_REF));
        $manager->persist($obj);
    }

    private function loadScheduler(ObjectManager $manager)
    {
        $items = [
            [
                'name' => 'Domain Queue Processing',
                'description' => 'Retrieves information for domains in the queue and adds them to DomainMOD.',
                'interval' => 'Every 5 Minutes',
                'expression' => '*/5 * * * * *',
                'slug' => 'domain-queue',
                'sort_order' => 10
            ],
            [
                'name' => 'Send Expiration Email',
                'description' => 'Sends an email out to everyone who\'s subscribed, letting them know of upcoming Domain & SSL Certificate expirations.<BR><BR>Users can subscribe via their User Profile.<BR><BR>Administrators can set the FROM email address and the number of days in the future to display in the email via System Settings.',
                'interval' => 'Daily',
                'expression' => '0 0 * * * *',
                'slug' => 'expiration-email',
                'sort_order' => 20
            ],
            [
                'name' => 'Update Conversion Rates',
                'description' => 'Retrieves the current currency conversion rates and updates the entire system, which keeps all of the financial information in DomainMOD accurate and up-to-date.<BR><BR>Users can set their default currency via their User Profile.',
                'interval' => 'Daily',
                'expression' => '0 0 * * * *',
                'slug' => 'update-conversion-rates',
                'sort_order' => 40
            ],
            [
                'name' => 'System Cleanup',
                'description' => '<em>Domains:</em> Converts all domain entries to lowercase.<br><br><em>TLDs:</em> Updates all TLD entries in the database to ensure their accuracy.<br><br><em>Segments:</em> Compares the Segment data to the domain database and records the status of each domain. This keeps the Segment filtering data up-to-date and running smoothly.<br><br><em>Fees:</em> Cross-references the Domain, SSL Certificate, and fee tables, making sure that everything is accurate. It also deletes all unused fees.',
                'interval' => 'Daily',
                'expression' => '0 0 * * * *',
                'slug' => 'cleanup',
                'sort_order' => 60
            ],
            [
                'name' => 'Check For New Version',
                'description' => 'Checks to see if there is a newer version of DomainMOD available to download.',
                'interval' => 'Daily',
                'expression' => '0 0 * * * *',
                'slug' => 'check-new-version',
                'sort_order' => 80
            ],
            [
                'name' => 'Data Warehouse Build',
                'description' => 'Rebuilds the Data Warehouse so that you have the most up-to-date information available.',
                'interval' => 'Daily',
                'expression' => '0 0 * * * *',
                'slug' => 'data-warehouse-build',
                'sort_order' => 100
            ]
        ];

        foreach ($items as $item) {
            $obj = new Scheduler();
            $obj->setName($item['name'])
                ->setDescription($item['description'])
                ->setInterval($item['interval'])
                ->setExpression($item['expression'])
                ->setSlug($item['slug'])
                ->setSortOrder($item['sort_order']);
            $manager->persist($obj);
        }
    }

    private function loadApiRegistrars(ObjectManager $manager)
    {
        $items = [
            [
                'name' => 'Above.com',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'DNSimple',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'DreamHost',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => false,
                'ret_autorenew_status' => true,
                'notes' => 'DreamHost does not currently allow the WHOIS privacy status of a domain to be retrieved via their API, so all domains added to the Domain Queue from a DreamHost account will have their WHOIS privacy status set to No by default.'
            ],
            [
                'name' => 'Dynadot',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'eNom',
                'req_account_username' => true,
                'req_account_password' => true,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => false,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'Fabulous',
                'req_account_username' => true,
                'req_account_password' => true,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => false,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'Freenom',
                'req_account_username' => true,
                'req_account_password' => true,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => false,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => 'Freenom currently only gives API access to reseller accounts.'
            ],
            [
                'name' => 'Gandi',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => false,
                'ret_autorenew_status' => true,
                'notes' => 'Gandi does not currently allow the WHOIS privacy status of a domain to be retrieved via their API, so all domains added to the Domain Queue from a Gandi account will have their WHOIS privacy status set to No by default.'
            ],
            [
                'name' => 'GoDaddy',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => true,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => 'When retrieving your list of domains from GoDaddy, the current limit is 1,000 domains. If you have more than this you should export the full list of domains from GoDaddy and paste it into the <strong>Domains to add</strong> field when adding domains via the Domain Queue.'
            ],
            [
                'name' => 'Internet.bs',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => true,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'Name.com',
                'req_account_username' => true,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'NameBright',
                'req_account_username' => true,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => true,
                'req_api_key' => false,
                'req_api_secret' => true,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'Namecheap',
                'req_account_username' => true,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'NameSilo',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => 'NameSilo\'s domains have 6 possible statuses: Active, Expired (grace period), Expired (restore period), Expired (pending delete), Inactive, and Pending Outbound Transfer<BR><BR>When retrieving your list of domains via the API, <STRONG>Inactive</STRONG> domains are not returned.<BR><BR>When retrieving the details of a specific domain via the API, <STRONG>Inactive</STRONG> and <STRONG>Expired (pending delete)</STRONG> domains will not return any data.'
            ],
            [
                'name' => 'OpenSRS',
                'req_account_username' => true,
                'req_account_password' => false,
                'req_reseller_id' => false,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => true,
                'lists_domains' => true,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => true,
                'notes' => null
            ],
            [
                'name' => 'ResellerClub',
                'req_account_username' => false,
                'req_account_password' => false,
                'req_reseller_id' => true,
                'req_api_app_name' => false,
                'req_api_key' => true,
                'req_api_secret' => false,
                'req_ip_address' => false,
                'lists_domains' => false,
                'ret_expiry_date' => true,
                'ret_dns_servers' => true,
                'ret_privacy_status' => true,
                'ret_autorenew_status' => false,
                'notes' => 'ResellerClub does not allow users to retrieve a list of their domains via the API, nor do they return the Auto Renewal status when retrieving the details of a domain. All domains imported via the API will have their Auto Renewal status set to No by default.'
            ]
        ];

        foreach ($items as $item) {
            $obj = new ApiRegistrar();
            $obj->setName($item['name'])
                ->setReqAccountUsername($item['req_account_username'])
                ->setReqAccountPassword($item['req_account_password'])
                ->setReqResellerId($item['req_reseller_id'])
                ->setReqApiAppName($item['req_api_app_name'])
                ->setReqApiKey($item['req_api_key'])
                ->setReqApiSecret($item['req_api_secret'])
                ->setReqIpAddress($item['req_ip_address'])
                ->setListsDomains($item['lists_domains'])
                ->setRetExpiryDate($item['ret_expiry_date'])
                ->setRetDnsServers($item['ret_dns_servers'])
                ->setRetPrivacyStatus($item['ret_privacy_status'])
                ->setRetAutorenewalStatus($item['ret_autorenew_status'])
                ->setNotes($item['notes']);
            $manager->persist($obj);
        }
    }

    private function loadSettings(ObjectManager $manager)
    {
        $obj = new Setting();
        $obj->setFullUrl('http://localhost')
            ->setEmailAddress('domainmod@example.com')
            ->setDbVersion('5.0.0')
            ->setDefaultOwnerDomains($this->getReference(self::DEFAULT_OWNER_REF))
            ->setDefaultOwnerSsl($this->getReference(self::DEFAULT_OWNER_REF))
            ->setEmailSignature($this->getReference(self::ADMIN_USER_REF))
            ->setSmtpPort(587)
            ->setUseSmtp(false);

        $manager->persist($obj);
    }
}
