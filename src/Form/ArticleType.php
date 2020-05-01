<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de votre article',
                'attr' => [
                    'placeholder' => 'Ceci est un exemple de titre d\'article il sera limité à 250 charactères sur la page d\'accueil',
                ]
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu de l\'article',
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => "",
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => "15M",
                        'mimeTypesMessage' => "Veuillez choisir un format d'image valide",
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Choisissez la catégorie correspondant à votre article'
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'type' => 'submit',
                    'class' => 'admin-button'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'attr' => [
                'class' => 'add-article-form'
            ]
        ]);
    }
}
