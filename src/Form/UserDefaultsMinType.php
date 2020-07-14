<?php
namespace App\Form;

use App\Entity\UserSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserDefaultsMinType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('defaultCurrency', CurrencyType::class, [
            'label' => 'Currency'
        ])
            ->add('defaultTimezone', TimezoneType::class, [
            'label' => 'Time Zone'
        ])
            ->add('expirationEmails', ChoiceType::class, [
            'label' => 'Subscribe to Domain & SSL Certificate expiration emails?',
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'Yes' => true,
                'No' => false
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSetting::class
        ]);
    }
}
