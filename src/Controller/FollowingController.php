<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\NewNotification;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class FollowingController extends AbstractController
{
    /**
     * @Route("/follow{id}", name="follow")
     */
    public function follow(User $user, NewNotification $myNotification)
    {
        $currentUser = $this->getUser();

        if ($user->getId() !== $currentUser->getId()) {
            $currentUser->follow($user);

            $this->getDoctrine()
                ->getManager()
                ->flush();
        }

        $myNotification->follow($user);

        return $this->redirectToRoute('account', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/unfollow{id}", name="unfollow")
     */
    public function unfollow(User $user)
    {
        $currentUser = $this->getUser();
        $currentUser->getFollowing()
            ->removeElement($user);

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->redirectToRoute('account', ['id' => $user->getId(), Response::HTTP_SEE_OTHER]);
    }
}
