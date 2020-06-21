<?php
namespace App\Form;

use App\Entity\Setting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class SystemSettingsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fullUrl', UrlType::class, [
            'label' => 'Full DomainMOD URL (100)',
            'attr' => [
                'placeholder' => 'http://localhost'
            ]
        ])
            ->add('emailAddress', EmailType::class, [
            'label' => 'System Email Address (100)',
            'attr' => [
                'placeholder' => 'domainmod@example.com'
            ]
        ])
            ->add('expirationDays', NumberType::class, [
            'label' => 'Expiration Days to Display'
        ])
            ->add('emailSignature', EntityType::class, [
            'label' => '',
            'class' => User::class,
            'choice_label' => function (?User $entity) {
                return $entity->getFirstName() . ' ' . $entity->getLastName();
            }
        ])
            ->add('currencyConverter', ChoiceType::class, [
            'label' => 'Currency Converter',
            'choices' => [
                'Exchange Rates API' => 'era'
            ]
        ])
            ->add('largeMode', CheckboxType::class, [
            'label' => 'Large Mode',
            'required' => false
        ])
            ->add('debugMode', CheckboxType::class, [
            'label' => 'Debugging Mode',
            'required' => false
        ])
            ->add('localPhpLog', CheckboxType::class, [
            'label' => 'Local PHP Log',
            'required' => false
        ])
            ->add('useSmtp', ChoiceType::class, [
            'label' => 'Use SMTP Server?',
            'help' => 'If the instance of PHP running on your DomainMOD server isn\'t configured to send mail, you can use an external SMTP server to send system emails.',
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'Yes' => true,
                'No' => false
            ],
            'choice_attr' => function ($choice, $key, $value) {
                return [
                    'class' => 'form-control square-red'
                ];
            }
        ])
            ->add('smtpServer', TextType::class, [
            'label' => 'SMTP Server(255)',
            'required' => false,
            'attr' => [
                'placeholder' => 'SMTP Server (255)'
            ]
        ])
            ->add('smtpProtocol', ChoiceType::class, [
            'label' => 'SMTP Server Protocol',
            'choices' => [
                'TLS' => 'tls',
                'SSL' => 'ssl'
            ]
        ])
            ->add('smtpPort', NumberType::class, [
            'label' => 'SMTP Server Port',
            'required' => false
        ])
            ->add('smtpEmailAddress', EmailType::class, [
            'label' => 'SMTP Email Address (100)',
            'required' => false,
            'attr' => [
                'placeholder' => 'SMTP Email Address (100)'
            ]
        ])
            ->add('smtpUsername', TextType::class, [
            'label' => 'SMTP Username (100)',
            'required' => false,
            'attr' => [
                'placeholder' => 'SMTP Username (100)'
            ]
        ])
            ->add('smtpPassword', TextType::class, [
            'label' => 'SMTP Password (255)',
            'required' => false,
            'attr' => [
                'placeholder' => 'SMTP Password (255)'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Setting::class
        ]);
    }
}
