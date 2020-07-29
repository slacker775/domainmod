<?php

namespace App\DataFixtures;

use App\Entity\CreationType;
use App\Entity\Currency;
use App\Entity\Fee;
use App\Entity\Registrar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FeeFixtures extends Fixture
{
    public const CURRENCY_USD = 'currency-usd';

    private $fees = [
        'GoDaddy.com, LLC'            => [
            'com'   => ['initial' => 8.29, 'renewal' => 8.29, 'privacy' => 9.99],
            'org'   => ['initial' => 9.99, 'renewal' => 20.99, 'privacy' => 9.99],
            'net'   => ['initial' => 14.99, 'renewal' => 19.99, 'privacy' => 9.99],
            'site'  => ['initial' => 0.99, 'renewal' => 11.99, 'privacy' => 9.99],
            'today' => ['initial' => 3.99, 'renewal' => 11.99, 'privacy' => 9.99],
            'info'  => ['initial' => 2.99, 'renewal' => 23.99, 'privacy' => 9.99],
            'us'    => ['initial' => 7.99, 'renewal' => 19.99, 'privacy' => 9.99],
            'co'    => ['initial' => 0.99, 'renewal' => 34.99, 'privacy' => 9.99],
            'me'    => ['initial' => 2.99, 'renewal' => 19.99, 'privacy' => 9.99],
            'mx'    => ['initial' => 49.99, 'renewal' => 49.99, 'privacy' => 9.99],
            'co.uk' => ['initial' => 11.99, 'renewal' => 11.99, 'privacy' => 9.99],
            'ru'    => ['initial' => 14.99, 'renewal' => 14.99, 'privacy' => 9.99],
            'biz'   => ['initial' => 7.99, 'renewal' => 24.99, 'privacy' => 9.99],
            'ca'    => ['initial' => 16.99, 'renewal' => 16.99, 'privacy' => 9.99],
        ],
        'Network Solutions, LLC'      => [
            'com' => ['initial' => 20.00, 'renewal' => 20.00, 'privacy' => 23.88]
        ],
        'Instra Corporation Pty Ltd.' => [
            'co.uk'  => ['initial' => 25.30, 'renewal' => 25.30, 'privacy' => 9.99],
            'org.uk' => ['initial' => 70, 'renewal' => 70, 'privacy' => 9.99],
            'nl'     => ['initial' => 105, 'renewal' => 105, 'privacy' => 9.99],
            'com'    => ['initial' => 56, 'renewal' => 56, 'privacy' => 9.99],
        ]
    ];

    public function load(ObjectManager $manager)
    {
        $currencyUSD = $manager->getRepository(Currency::class)
            ->findOneByCurrency('USD');

        $this->addReference(self::CURRENCY_USD, $currencyUSD);

        $this->loadDomainFees($manager);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    private function loadDomainFees(ObjectManager $manager)
    {
        foreach ($this->fees as $registrarName => $fees) {

            $registrar = $this->getRegistrar($manager, $registrarName);

            foreach ($fees as $key => $fee) {
                $obj = new Fee();
                $obj->setCurrency($this->getReference(self::CURRENCY_USD))
                    ->setRegistrar($registrar)
                    ->setInitialFee($fee['initial'] ?? 0.0)
                    ->setRenewalFee($fee['renewal'] ?? 0.0)
                    ->setPrivacyFee($fee['privacy'] ?? 0.0)
                    ->setTransferFee($fee['transfer'] ?? 0.0)
                    ->setMiscFee($fee['misc'] ?? 0.0)
                    ->setTld($key)
                    ->setCreatedBy('fixture');
                $manager->persist($obj);
            }
        }
    }

    private function getRegistrar(ObjectManager $manager, string $name): Registrar
    {
        $registrar = $manager->getRepository(Registrar::class)
            ->findOneByName($name);

        if ($registrar === null) {
            $registrar = new Registrar();
            $registrar->setName($name)
                ->setCreationType($manager->getRepository(CreationType::class)
                    ->findOneByName('Installation'))
                    ->setCreatedBy('system');
            $manager->persist($registrar);
        }
        return $registrar;
    }
}
