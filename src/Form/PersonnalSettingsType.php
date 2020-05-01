<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PersonnalSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'required' => true,
                    'value' => $options['userFirstname'],
                ]
            ])
            ->add('lastname', TextType::class, [
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'label' => 'Nom',
                    'attr' => [
                        'required' => true,
                        'value' => $options['userLastname'],
                    ]
                ]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer les modifications',
                'attr' => [
                    'class' => 'read-more',
                ]
            ])
            ->setAction('/utilisateur/edit-personnal-settings');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'id' => 'personnalSettingsForm'
            ],
            'userFirstname' => false,
            'userLastname' => false,
        ]);
    }
}
