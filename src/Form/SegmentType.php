<?php

namespace App\Form;

use App\Entity\Segment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SegmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Segment Name (35)'])
            ->add('segment', TextareaType::class, ['label' => 'Segment Domains (one per line)'])
            ->add('description', TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('notes', TextareaType::class, ['label' => 'Notes', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Segment::class,
        ]);
    }
}
