<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/testfollow{id}", name="followtest")
     */
    public function follow(User $user, EntityManagerInterface $manager)
    {
        $currentUser = $this->getUser();

        if ($user->getId() !== $currentUser->getId() && $user->getFollowers()->contains($currentUser) == false) {
            $currentUser->follow($user);
            $manager->persist($user);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Abonnement ajouté',
                'count' => $user->getFollowers()->count(),
            ], 200);
        } else {
            if ($user->getId() !== $currentUser->getId() && $user->getFollowers()->contains($currentUser) != false) {
                $currentUser->getFollowing()
                    ->removeElement($user);
                $manager->persist($user);
                $manager->flush();

                return $this->json([
                    'code' => 200,
                    'message' => 'Abonnement supprimé',
                    'count' => $user->getFollowers()->count(),
                ], 200);
            }
        }
    }
}
