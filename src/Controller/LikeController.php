<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Repository\LikeRepository;
use App\Service\NewNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    /**
     * Liker un post
     * 
     * @Route("/post/{id}/like", name="post_like")
     *
     * @param Post $post
     * @param EntityManagerInterface $manager
     * @param LikeRepository $likeRepo
     * @return Response
     */
    public function likes(Post $post, EntityManagerInterface $manager, LikeRepository $likeRepo, NewNotification $newNotification): Response
    {
        $user = $this->getUser();
        $postUser = $post->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Non autorisé"
        ], 403);

        if ($post->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy(['post' => $post, 'user' =>  $user]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => "Like supprimé",
                'likes' => $likeRepo->count(['post' => $post])
            ], 200);
        }

        $like = new Like();
        $like->setPost($post)
            ->setUser($user);

        $manager->persist($like, $post);
        $manager->flush();

        if ($post->getUser() != $user) {
            $newNotification->like($postUser);
        }

        return $this->json([
            'code' => 200,
            'message' => 'Like ajouté',
            'likes' => $likeRepo->count(['post' => $post])
        ], 200);
    }
}
