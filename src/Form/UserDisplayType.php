<?php
namespace App\Form;

use App\Entity\UserSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class UserDisplayType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numberOfDomains', NumberType::class,['label' => 'Number of domains per page'])
            ->add('displayDomainOwner')
            ->add('displayDomainRegistrar')
            ->add('displayDomainAccount')
            ->add('displayDomainExpiryDate')
            ->add('displayDomainCategory')
            ->add('displayDomainDns')
            ->add('displayDomainHost')
            ->add('displayDomainIp')
            ->add('displayDomainTld')
            ->add('displayDomainFee')
            ->add('numberOfSslCerts', NumberType::class,['label' => 'Number of SSL certificates per page'])
            ->add('displaySslOwner')
            ->add('displaySslProvider')
            ->add('displaySslAccount')
            ->add('displaySslDomain')
            ->add('displaySslType')
            ->add('displaySslExpiryDate')
            ->add('displaySslIp')
            ->add('displaySslCategory')
            ->add('displaySslFee')
            ->add('displayInactiveAssets', CheckboxType::class, [
            'label' => 'Display Inactive Assets'
        ])
            ->add('displayDwIntroPage', CheckboxType::class, [
            'label' => 'Display intro page'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSetting::class
        ]);
    }
}
