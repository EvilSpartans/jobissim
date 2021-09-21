<?php

namespace App\Messaging;

use App\Entity\Messaging;

class Builder
{
    public function getMessagings(array $messagings): array
    {
        $output = [];
        /** @var Messaging $messaging */
        foreach($messagings as $messaging) {
            $output['messaging'][] = [
                'id' => $messaging->getId(),
                'createdAt' => $messaging->getCreatedAt(),
                'author' => $messaging->getAuthor(),
                'contributors' => $messaging->getParticipants(),
                'messages' => $messaging->getMessages()
            ];
        }

        return $output;
    }
}