<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Dns;
use App\Entity\Domain;
use App\Entity\Hosting;
use App\Entity\IpAddress;
use App\Entity\Owner;
use App\Entity\Registrar;
use App\Entity\RegistrarAccount;
use App\Entity\Segment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('segment', EntityType::class, ['class' => Segment::class, 'label' => false, 'required' => false, 'placeholder' => 'Segment Filter - OFF'])
            ->add('registrar', EntityType::class, ['class' => Registrar::class, 'label' => false, 'required' => false, 'placeholder' => 'Registrar - ALL'])
            ->add('account', EntityType::class, ['class' => RegistrarAccount::class, 'label' => false, 'required' => false, 'placeholder' => 'Registrar Account - ALL'])
            ->add('dns', EntityType::class, ['class' => Dns::class, 'label' => false, 'required' => false, 'placeholder' => 'DNS Profile - ALL'])
            ->add('ip', EntityType::class, ['class' => IpAddress::class, 'label' => false, 'required' => false, 'placeholder' => 'IP Address - ALL'])
            ->add('hosting', EntityType::class, ['class' => Hosting::class, 'label' => false, 'required' => false, 'placeholder' => 'Web Hosting Provider - ALL'])
            ->add('category', EntityType::class, ['class' => Category::class, 'label' => false, 'required' => false, 'placeholder' => 'Category - ALL'])
            ->add('owner',
                EntityType::class,
                ['class'       => Owner::class,
                 'label'       => false,
                 'required'    => false,
                 'placeholder' => 'Owner - ALL'])
            /*           ->add('tld', EntityType::class, ['class' => Domain::class, 'query_builder' => function (EntityRepository $repository) {
                           return $repository->createQueryBuilder('d')
                               ->distinct()
                               ->select('d.tld')
                               ->orderBy('d.tld', 'ASC');
                       }, 'required' => false, 'attr' => ['placeholder' => 'TLD - ALL']])
            */
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Active'               => Domain::STATUS_ACTIVE,
                    'Expired'              => Domain::STATUS_EXPIRED,
                    'Live'                 => 'Live',
                    'Pending Transfer'     => Domain::STATUS_PENDING_TRANSFER,
                    'Pending Renewal'      => Domain::STATUS_PENDING_RENEWAL,
                    'Pending Other'        => Domain::STATUS_PENDING_OTHER,
                    'Pending Registration' => Domain::STATUS_PENDING_REGISTRATION,
                    'Sold'                 => Domain::STATUS_SOLD],
                'placeholder' => 'All',
                'label' => false,
                'required' => false])
            ->add('count', NumberType::class, ['required' => false, 'label' => false, 'attr' => ['placeholder' => 50]])
            ->add('keyword', TextType::class, ['label' => 'Domain Keyword Search', 'required' => false, 'attr' => ['placeholder' => 'Domain Keyword Search']])
            ->add('expiringBetween', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
