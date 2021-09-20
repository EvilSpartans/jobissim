<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Messaging;
use App\Form\MessageType;
use App\Form\MessagingType;
use App\Repository\MessageRepository;
use App\Repository\MessagingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagingController extends AbstractController
{
    /**
     * @Route("/messaging", name="messaging")
     */
    public function index(MessagingRepository $messagingRepository): Response
    {
        $user = $this->getUser();
        $conversations = $messagingRepository->findByAuthorOrParticipants($user);

        return $this->render('messaging/index.html.twig', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * @Route("/messaging-{id}", name="messaging_show", methods={"GET","POST"})
     */
    public function show(MessagingRepository $messagingRepository, MessageRepository $messageRepository, Messaging $messaging, Request $request): Response
    {
        $user = $this->getUser();
        $conversations = $messagingRepository->findByAuthorOrParticipants($user);
        $messages = $messageRepository->findByConversation($messaging);

        //New message
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setAuthor($user);
            $message->setMessaging($messaging);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('messaging_show', ['id' => $messaging->getId()], Response::HTTP_SEE_OTHER);
        }

        if ($messaging->getAuthor() == $user || $messaging->getParticipants()->contains($user) != false) {
            return $this->render('messaging/show.html.twig', [
                'conversations' => $conversations,
                'messaging' => $messaging,
                'messages' => $messages,
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('messaging', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/new-messaging", name="messaging_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conversation = new Messaging();
        $form = $this->createForm(MessagingType::class, $conversation);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $conversation->setAuthor($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conversation);
            $entityManager->flush();

            return $this->redirectToRoute('messaging', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('messaging/new.html.twig', [
            'conversation' => $conversation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/profile-messaging_{id}", name="messaging_profile", methods={"GET","POST"})
     */
    public function newOrGet(User $user, MessagingRepository $messagingRepository): Response
    {
        $conversation = new Messaging();
        $currentUser = $this->getUser();
        $messaging = $messagingRepository->findByAuthorAndParticipant($user->getId(), $currentUser->getId());

        if ($messaging == true) {
            return $this->redirectToRoute('messaging_show', ['id' => $messaging->getId()], Response::HTTP_SEE_OTHER);
        } else {
            $conversation->setAuthor($currentUser);
            $conversation->addParticipant($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conversation);
            $entityManager->flush();

            return $this->redirectToRoute('messaging_show', ['id' => $conversation->getId()], Response::HTTP_SEE_OTHER);
        }
    }
}
