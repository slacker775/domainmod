<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'label' => 'First Name (50)',
            'attr' => [
                'placeholder' => 'First Name (50)'
            ]
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Last Name (50)',
            'attr' => [
                'placeholder' => 'Last Name (50)'
            ]
        ])
        ->add('username', TextType::class, [
            'label' => 'Username (30)',
            'attr' => [
                'placeholder' => 'Username (30)'
            ]
        ])
        ->add('emailAddress', EmailType::class, [
            'label' => 'Email Address (100)',
            'attr' => [
                'placeholder' => 'Email Address (100)'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
