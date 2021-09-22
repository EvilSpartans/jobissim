<?php

namespace App\Service;

use App\Repository\MessageRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CountMessage
{
    private $count = null;
    private $messageRepository;
    private $tokenStorage;

    public function __construct(MessageRepository $messageRepository, TokenStorageInterface $tokenStorage)
    {
        $this->messageRepository = $messageRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function count()
    {
        $user = $this->tokenStorage->getToken()->getUser('id');
        return $this->count ?? $this->messageRepository->countMessages($user);
    }
}
