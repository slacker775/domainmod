<?php

namespace App\Form;

use App\Entity\SslCertType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SslCertTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('notes')
            ->add('created')
            ->add('updated')
            ->add('creationType')
            ->add('createdBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SslCertType::class,
        ]);
    }
}
