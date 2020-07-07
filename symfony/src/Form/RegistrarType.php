<?php
namespace App\Form;

use App\Entity\Registrar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use App\Entity\ApiRegistrar;

class RegistrarType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Registrar Name (100)',
            'required' => true
        ])
            ->add('url', UrlType::class, [
            'label' => 'Registrar\'s URL (100)',
            'required' => false
        ])
            ->add('apiRegistrar', EntityType::class, [
            'class' => ApiRegistrar::class,
            'choice_label' => 'name',
            'label' => 'API Support',
            'required' => false
        ])
            ->add('notes', TextareaType::class, [
            'label' => 'Notes',
            'required' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Registrar::class
        ]);
    }
}
