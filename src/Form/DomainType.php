<?php
namespace App\Form;

use App\Entity\Domain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\RegistrarAccount;
use App\Entity\Dns;
use App\Entity\IpAddress;
use App\Entity\Hosting;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;

class DomainType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $domain = $event->getData();
            $form = $event->getForm();

            if (! $domain || null == $domain->getId()) {

                $form->add('name', TextType::class, [
                    'label' => 'Domain (255)',
                    'attr' => [
                        'placeholder' => 'Domain (255)'
                    ]
                ]);
            }
        });

        $builder->add('function', TextType::class, [
            'label' => 'Function (255)',
            'required' => false,
            'attr' => [
                'placeholder' => 'Function (255)'
            ]
        ])
            ->add('expiryDate', DateType::class, [
            'label' => 'Expiry Date (YYYY-MM-DD)',
            'widget' => 'single_text',
            'html5' => true
        ])
            ->add('account', EntityType::class, [
            'class' => RegistrarAccount::class,
            'label' => 'Registrar Account',
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('a')
                    ->orderBy('a.registrar')
                    ->addOrderBy('a.owner')
                    ->addOrderBy('a.username');
            }
        ])
            ->add('dns', EntityType::class, [
            'class' => Dns::class,
            'label' => 'DNS Profile',
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('a')
                    ->orderBy('a.name');
            }
        ])
            ->add('ip', EntityType::class, [
            'class' => IpAddress::class,
            'label' => 'IP Address'
        ])
            ->add('hosting', EntityType::class, [
            'class' => Hosting::class,
            'label' => 'Web Hosting Provider'
        ])
            ->add('category', EntityType::class, [
            'class' => Category::class
        ])
            ->add('status', ChoiceType::class, [
            'label' => 'Domain Status',
            'choices' => [
                'Active' => '1',
                'Pending (Transfer)' => '2',
                'Pending (Renewal)' => '3',
                'Pending (Other)' => '4',
                'Pending (Registration)' => '5',
                'Sold' => '10',
                'Expired' => '0'
            ]
        ])
            ->add('autorenew', CheckboxType::class, [
            'label' => 'Auto Renewal?',
            'required' => false
        ])
            ->add('privacy', CheckboxType::class, [
            'label' => 'Privacy Enabled?',
            'required' => false
        ])
            ->add('notes', TextareaType::class, [
            'label' => 'Notes',
            'required' => false,
            'attr' => [
                'placeholder' => 'Notes'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Domain::class
        ]);
    }
}
