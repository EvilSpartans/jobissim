<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search", methods={"GET","POST"})
     */
    public function search(UserRepository $userRepository, PostRepository $postRepository): Response
    {

        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $users = $userRepository->search($_POST['search']);
        } else {
            $users = null;
        }
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $posts = $postRepository->search($_POST['search']);
        } else {
            $posts = null;
        }

        return $this->render('search/index.html.twig', [
            'users' => $users,
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     */
    public function autocomplete(UserRepository $userRepository, PostRepository $postRepository, Request $request): JsonResponse
    {
        $term = $request->request->get('search');
        $users = $userRepository->autocomplete($term);

        $outputUsers = [];
        foreach ($users as $user) {
            $outputUsers[$user['id']] = [
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'avatar' => $user['avatar'],
            ];
        }

        $outputPost = [];
        $posts = $postRepository->autocomplete($term);
        foreach ($posts as $post) {
            $outputPost[ $post['id']] = [
                'title' => $post['title'],
                'image' =>  $post['image']
            ];
        }

        return new JsonResponse($outputUsers, $outputPost, Response::HTTP_OK);
    }
}
