<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Messaging;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MessagingType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('participants', EntityType::class, [
                'class' => User::class,
                'label' => 'Participants : ',
                'required' => true,
                'multiple' => true,
                'placeholder' => 'Sélectionner',
                'query_builder' => function (UserRepository $er) {
                    $user = $this->tokenStorage->getToken()->getUser();
                    return $er->withoutCurrentUser($user);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messaging::class,
        ]);
    }
}
