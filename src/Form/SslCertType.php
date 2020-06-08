<?php
namespace App\Form;

use App\Entity\Domain;
use App\Entity\IpAddress;
use App\Entity\SslAccount;
use App\Entity\SslCert;
use App\Entity\SslCertType as SslType;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SslCertType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Host / Label (100)'
        ])
            ->add('expiryDate', DateType::class, [
            'label' => 'Expiry Date (YYYY-MM-DD)',
            'html5' => true,
            'widget' => 'single_text'
        ])
            ->add('domain', EntityType::class, [
            'class' => Domain::class,
            'label' => 'Domain'
        ])
            ->add('account', EntityType::class, [
            'class' => SslAccount::class,
            'label' => 'SSL Provider Account'
        ])
            ->add('type', EntityType::class, [
            'class' => SslType::class,
            'label' => 'Certificate Type'
        ])
            ->add('ip', EntityType::class, [
            'class' => IpAddress::class,
            'label' => 'IP Address'
        ])
            ->add('category', EntityType::class, [
            'class' => Category::class,
            'label' => 'Category'
        ])
            ->add('status', ChoiceType::class, [
            'label' => 'Certificate Status',
            'choices' => [
                'Active' => '1',
                'Pending (Registration)' => '5',
                'Pending (Renewal)' => '3',
                'Pending (Other)' => '4',
                'Expired' => '0'
            ]
        ])
            ->add('notes', TextareaType::class, [
            'label' => 'Notes',
                'required' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SslCert::class
        ]);
    }
}
