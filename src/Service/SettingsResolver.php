<?php
declare(strict_types = 1);
namespace App\Service;

use App\Entity\User;
use App\Repository\SettingRepository;
use App\Repository\UserSettingRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsResolver
{

    private SettingRepository $settingRepository;

    private UserSettingRepository $userSettingRepository;

    public function __construct(SettingRepository $settingRepostory, UserSettingRepository $userSettingRepository)
    {
        $this->settingRepository = $settingRepostory;
        $this->userSettingRepository = $userSettingRepository;
    }

    public function resolveSettings(User $user): array
    {
        $systemSettings = $this->settingRepository->getSettings();
        $userSettings = $this->userSettingRepository->getSettings($user);

        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'largeMode' => false,
            'defaultCategoryDomains' => null,
            'defaultCategorySsl' => null,
            'defaultDns' => null,
            'defaultHost' => null,
            'defaultIpAddressDomains' => null,
            'defaultIpAddressSsl' => null,
            'defaultOwnerDomains' => null,
            'defaultOwnerSsl' => null,
            'defaultRegistrar' => null,
            'defaultRegistrarAccount' => null,
            'defaultSslProviderAccount' => null,
            'defaultSslType' => null,
            'defaultSslProvider' => null,
            'defaultCurrency' => 'USD',
            'defaultTimezone' => 'America/New_York',
            'expirationEmails' => true,
            'numberOfDomains' => 50,
            'numberOfSslCerts' => 50,
            'displayDomainOwner' => true,
            'displayDomainRegistrar' => false,
            'displayDomainAccount' => true,
            'displayDomainExpiryDate' => true,
            'displayDomainCategory' => true,
            'displayDomainDns' => true,
            'displayDomainHost' => false,
            'displayDomainIp' => false,
            'displayDomainTld' => true,
            'displayDomainFee' => true,
            'displaySslOwner' => true,
            'displaySslProvider' => false,
            'displaySslAccount' => true,
            'displaySslDomain' => true,
            'displaySslType' => true,
            'displaySslExpiryDate' => true,
            'displaySslIp' => false,
            'displaySslCategory' => false,
            'displaySslFee' => false,
            'displayInactiveAssets' => false,
            'displayDwIntroPage' => true
        ]);
        $options = array_merge($systemSettings->toArray(), $userSettings->toArray());
        
        $settings = $resolver->resolve($options);
        return $settings;
    }
}