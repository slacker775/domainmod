<?php

namespace App\Form;

use App\Entity\SslAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SslAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ownerId')
            ->add('sslProviderId')
            ->add('emailAddress')
            ->add('username')
            ->add('password')
            ->add('reseller')
            ->add('resellerId')
            ->add('notes')
            ->add('creationTypeId')
            ->add('createdBy')
            ->add('created')
            ->add('updated')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SslAccount::class,
        ]);
    }
}
