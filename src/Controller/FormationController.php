<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\SubCategoriesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation")
     */
    public function index(PostRepository $postRepository, SubCategoriesRepository $subCategoriesRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $id = $subCategoriesRepository->findOneBy(['name' => 'formation']);
        $formations = $paginator->paginate(
            $postRepository->findPostByCategory($id),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }
}
