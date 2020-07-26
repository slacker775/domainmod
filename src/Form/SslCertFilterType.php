<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\IpAddress;
use App\Entity\Owner;
use App\Entity\SslAccount;
use App\Entity\SslCert;
use App\Entity\SslCertType as SslCertTypeEntity;
use App\Entity\SslProvider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SslCertFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domain',null,['required' => false])
            ->add('sslProvider', EntityType::class, ['class' => SslProvider::class, 'label' => false, 'required' => false, 'placeholder' => 'SSL Provider - ALL'])
            ->add('account', EntityType::class, ['class' => SslAccount::class, 'label' => false, 'required' => false, 'placeholder' => 'SSL Account - ALL'])
            ->add('owner', EntityType::class, ['class' => Owner::class, 'label' => false, 'required' => false, 'placeholder' => 'Owner - ALL'])
            ->add('type', EntityType::class, ['class' => SslCertTypeEntity::class, 'label' => false, 'required' => false, 'placeholder' => 'SSL Type - ALL'])
            ->add('ip', EntityType::class, ['class' => IpAddress::class, 'label' => false, 'required' => false, 'placeholder' => 'IP Address - ALL'])
            ->add('category', EntityType::class, ['class' => Category::class, 'label' => false, 'required' => false, 'placeholder' => 'Category - ALL'])
            ->add('status', ChoiceType::class, ['choices' => [
                'Active'               => SslCert::STATUS_ACTIVE,
                'Expired'              => SslCert::STATUS_EXPIRED,
                'Live'                 => 'Live',
                'Pending Renewal'      => SslCert::STATUS_PENDING_RENEWAL,
                'Pending Other'        => SslCert::STATUS_PENDING_OTHER,
                'Pending Registration' => SslCert::STATUS_PENDING_REGISTRATION],
            ])
            ->add('keyword', TextType::class, ['label' => 'Domain Keyword Search', 'required' => false, 'attr' => ['placeholder' => 'Domain Keyword Search']])
            ->add('expiringBetween', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
