<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewNotification
{
    /**
     * Call manager and currentUser
     *
     * @var [type]
     */
    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function follow(User $user)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser('id');
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setContent("${currentUser} vient de s'abonner");
        $notification->setSeen(0);
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    public function like(User $user)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser('id');
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setContent("${currentUser} a aimé ta video");
        $notification->setSeen(0);
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }
}
