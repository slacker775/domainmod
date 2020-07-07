<?php
namespace App\Form;

use App\Entity\Fee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Currency;

class FeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tld', TextType::class, [
            'label' => 'TLD',
            'attr' => [
                'placeholder' => 'com'
            ]
        ])
            ->add('initialFee', MoneyType::class, [
            'label' => 'Initial Fee',
            'currency' => false
        ])
            ->add('renewalFee', MoneyType::class, [
            'label' => 'Renewal Fee',
            'currency' => false
        ])
            ->add('transferFee', MoneyType::class, [
            'label' => 'Transfer Fee',
            'currency' => false
        ])
            ->add('privacyFee', MoneyType::class, [
            'label' => 'Privacy  Fee',
            'currency' => false,
            'required' => false
        ])
            ->add('miscFee', MoneyType::class, [
            'label' => 'Misc Fee',
            'currency' => false,
            'required' => false
        ])
            ->add('currency', EntityType::class, [
            'label' => 'Currency',
            'class' => Currency::class,
            'empty_data' => 'US Dollar'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fee::class
        ]);
    }
}
