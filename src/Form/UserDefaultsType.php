<?php
namespace App\Form;

use App\Entity\Category;
use App\Entity\Dns;
use App\Entity\Hosting;
use App\Entity\IpAddress;
use App\Entity\Owner;
use App\Entity\Registrar;
use App\Entity\RegistrarAccount;
use App\Entity\SslAccount;
use App\Entity\SslCertType;
use App\Entity\SslProvider;
use App\Entity\UserSetting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDefaultsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('defaultRegistrar', EntityType::class, [
            'label' => 'Default Domain Registrar',
            'class' => Registrar::class
        ])
            ->add('defaultRegistrarAccount', EntityType::class, [
            'label' => 'Default Domain Registrar Account',
            'class' => RegistrarAccount::class
        ])
            ->add('defaultDns', EntityType::class, [
            'label' => 'Default DNS Profile',
            'class' => Dns::class
        ])
            ->add('defaultHost', EntityType::class, [
            'label' => 'Default Web Hosting Provider',
            'class' => Hosting::class
        ])
            ->add('defaultIpAddressDomains', EntityType::class, [
            'label' => 'Default IP Address',
            'class' => IpAddress::class
        ])
            ->add('defaultCategoryDomains', EntityType::class, [
            'label' => 'Default Category',
            'class' => Category::class
        ])
            ->add('defaultOwnerDomains', EntityType::class, [
            'label' => 'Default Account Owner',
            'class' => Owner::class
        ])
            ->
        add('defaultSslProvider', EntityType::class, [
            'label' => 'Default SSL Provider',
            'class' => SslProvider::class
        ])
            ->add('defaultSslProviderAccount', EntityType::class, [
            'label' => 'Default SSL Provider Account',
            'class' => SslAccount::class
        ])
            ->add('defaultSslType', EntityType::class, [
            'label' => 'Default SSL Type',
            'class' => SslCertType::class
        ])
            ->add('defaultIpAddressSsl', EntityType::class, [
            'label' => 'Default IpAddress',
            'class' => IpAddress::class
        ])
            ->add('defaultCategorySsl', EntityType::class, [
            'label' => 'Default Category',
            'class' => Category::class
        ])
            ->add('defaultOwnerSsl', EntityType::class, [
            'label' => 'Default Account Owner',
            'class' => Owner::class
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSetting::class
        ]);
    }
}
