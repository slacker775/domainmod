<?php

namespace App\Form;

use App\Entity\SslCert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SslCertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip')
            ->add('name')
            ->add('expiryDate')
            ->add('totalCost')
            ->add('notes')
            ->add('status')
            ->add('feeFixed')
            ->add('createdBy')
            ->add('insertTime')
            ->add('updateTime')
            ->add('owner')
            ->add('sslProvider')
            ->add('account')
            ->add('domain')
            ->add('type')
            ->add('category')
            ->add('fee')
            ->add('creationType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SslCert::class,
        ]);
    }
}
