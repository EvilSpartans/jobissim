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
     * @Route("/autocomplete", name="autocomplete", methods={"GET","POST"})
     */
    public function autocomplete(UserRepository $userRepository, PostRepository $postRepository, Request $request): Response
    {
        $users = $userRepository->autocomplete();
        $posts = $postRepository->autocomplete();

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(Response::HTTP_OK);
        }
    }
}
