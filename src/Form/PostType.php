<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Categories;
use App\Entity\SubCategories;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'label' => 'Catégorie :',
                'placeholder' => '',
                'empty_data'  => null,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire',
                    ]),
                ],
            ])
            ->add('subcategory', EntityType::class, [
                'class' => SubCategories::class,
                'label' => 'Contenu :',
                'placeholder' => '',
                'empty_data'  => null,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'required' => false
            ])
            ->add('hashtag', TextType::class, [
                'label' => 'Hashtags :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire',
                    ]),
                ],
            ])
            ->add('videoFile', VichFileType::class, [
                'label' => false,
                'allow_delete' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir une vidéo',
                    ]),
                ],
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => false,
                'allow_delete' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir une image',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
