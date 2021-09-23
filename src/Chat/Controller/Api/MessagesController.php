<?php

declare(strict_types=1);

namespace App\Chat\Controller\Api;

use App\Entity\Messaging;
use App\Repository\MessageRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @FOSRest\Route("/api-message/")
 */
final class MessagesController extends AbstractFOSRestController
{
    /**
     * @Security("is_granted('ROLE_USER')")
     *
     * @OA\Tag(name="Messages")
     * @OA\Response(
     *     response="200",
     *     description="retrieve list of chat for current user successfully",
     *     @OA\Schema(@OA\Items(ref=@Model(type="App\Entity\Message")))
     * )
     * @OA\Response(response="404", description="entity not found")
     * @OA\Response(response="403", description="Unauthorized user to make this action")
     * @OA\Response(response="500", description="server error")
     *
     * @FOSRest\Get("get-messages-by-messaging/{id}", name="get_messages", methods={"GET"})
     * @FOSRest\View(statusCode=Response::HTTP_OK)
     *
     * @param Messaging $messaging
     * @param MessageRepository $messageRepository
     *
     *
     * @return string
     */
    public function __invoke(Messaging $messaging, MessageRepository $messageRepository): string
    {
        if (!$this->getUser()) {
            throw new \LogicException('Unauthorized user to make this action');
        }

        return $this->renderView('chat/messages.html.twig', [
            'messages' => $messageRepository->getMessages($messaging->getId())
        ]);
    }
}