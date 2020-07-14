<?php

namespace App\Form;

use App\Entity\Dns;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DnsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label' => 'Profile Name'])
            ->add('dns1', TextType::class,['label' => 'DNS Server 1'])
            ->add('dns2', TextType::class,['label' => 'DNS Server 2', 'required' => false])
            ->add('dns3', TextType::class,['label' => 'DNS Server 3', 'required' => false])
            ->add('dns4', TextType::class,['label' => 'DNS Server 4', 'required' => false])
            ->add('dns5', TextType::class,['label' => 'DNS Server 5', 'required' => false])
            ->add('dns6', TextType::class,['label' => 'DNS Server 6', 'required' => false])
            ->add('dns7', TextType::class,['label' => 'DNS Server 7', 'required' => false])
            ->add('dns8', TextType::class,['label' => 'DNS Server 8', 'required' => false])
            ->add('dns9', TextType::class,['label' => 'DNS Server 9', 'required' => false])
            ->add('dns10', TextType::class,['label' => 'DNS Server 10', 'required' => false])
            ->add('ip1', TextType::class,['label' => 'IP Address 1', 'required' => false])
            ->add('ip2', TextType::class,['label' => 'IP Address 2', 'required' => false])
            ->add('ip3', TextType::class,['label' => 'IP Address 3', 'required' => false])
            ->add('ip4', TextType::class,['label' => 'IP Address 4', 'required' => false])
            ->add('ip5', TextType::class,['label' => 'IP Address 5', 'required' => false])
            ->add('ip6', TextType::class,['label' => 'IP Address 6', 'required' => false])
            ->add('ip7', TextType::class,['label' => 'IP Address 7', 'required' => false])
            ->add('ip8', TextType::class,['label' => 'IP Address 8', 'required' => false])
            ->add('ip9', TextType::class,['label' => 'IP Address 9', 'required' => false])
            ->add('ip10', TextType::class,['label' => 'IP Address 10', 'required' => false])
            ->add('notes', TextareaType::class,['label' => 'Notes', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dns::class,
        ]);
    }
}
