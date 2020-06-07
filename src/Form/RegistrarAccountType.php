<?php
namespace App\Form;

use App\Entity\RegistrarAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Registrar;
use App\Entity\Owner;
use App\Entity\IpAddress;

class RegistrarAccountType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('registrar', EntityType::class, [
            'label' => 'Registrar',
            'class' => Registrar::class
        ])
            ->add('owner', EntityType::class, [
            'label' => 'Account Owner',
            'class' => Owner::class
        ])
            ->add('emailAddress', TextType::class, [
            'label' => 'Email Address (100)',
            'required' => false
        ])
            ->add('username', TextType::class, [
            'label' => 'Username (100)'
        ])
            ->add('password', TextType::class, [
            'label' => 'Password (255)',
            'required' => false
        ])
            ->add('reseller', CheckboxType::class, [
            'label' => 'Reseller Account?',
            'required' => false
        ])
            ->add('resellerId', TextType::class, [
            'label' => 'Reseller ID (100)',
            'required' => false
        ])
            ->add('apiAppName', TextType::class, [
            'label' => 'API App Name',
            'required' => false
        ])
            ->add('apiKey', TextType::class, [
            'label' => 'API Key',
            'required' => false
        ])
            ->add('apiSecret', TextType::class, [
            'label' => 'API Secret',
            'required' => false
        ])
            ->add('apiIp', EntityType::class, [
            'label' => 'API IP Address',
            'class' => IpAddress::class
        ])
            ->add('notes', TextareaType::class, [
            'label' => 'Notes',
            'required' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegistrarAccount::class
        ]);
    }
}
