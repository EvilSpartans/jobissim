<?php

namespace App\Service;

use App\Repository\NotificationRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CountNotification
{
    private $count = null;
    private $notificationRepository;
    private $tokenStorage;

    public function __construct(NotificationRepository $notificationRepository, TokenStorageInterface $tokenStorage)
    {
        $this->notificationRepository = $notificationRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function count()
    {
        $user = $this->tokenStorage->getToken()->getUser('id');
        return $this->count ?? $this->notificationRepository->countNotifications($user);
    }
}
