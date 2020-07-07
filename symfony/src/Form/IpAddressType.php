<?php
namespace App\Form;

use App\Entity\IpAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class IpAddressType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'IP Address Name (100)',
            'attr' => [
                'placeholder' => 'IP Address Name (100)'
            ]
        ])
            ->add('ip', TextType::class, [
            'label' => 'IP Address (100)',
            'attr' => [
                'placeholder' => 'IP Address (100)'
            ]
        ])
            ->add('rdns', TextType::class, [
            'label' => 'rDNS (100)',
            'required' => false,
            'attr' => [
                'placeholder' => 'rDNS (100)'
            ]
        ])
            ->add('notes', TextareaType::class, [
            'label' => 'Notes',
            'required' => false,
            'attr' => [
                'placeholder' => 'Notes'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IpAddress::class
        ]);
    }
}
