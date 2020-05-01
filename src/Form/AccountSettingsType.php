<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Nouvelle adresse email',
                'attr' => [
                    'required' => true,
                    'value' => $options['userEmail'],
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Nouveau nom d\'utilisateur',
                'attr' => [
                    'required' => true,
                    'value' => $options['userUsername'],
                ]
            ])
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'required' => true,
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'attr' => [
                    'required' => true,
                ]
            ])
            ->add('newPasswordConfirm', PasswordType::class, [
                'label' => 'Confirmation du nouveau mot de passe',
                'attr' => [
                    'required' => true,
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer les modifications',
                'attr' => [
                    'class' => 'button btn read-more',
                ]
            ])
            ->setAction('/utilisateur/edit-account-settings')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'id' => 'accountSettingsForm'
            ],
            'userEmail' => false,
            'userUsername' => false,
        ]);
    }
}
