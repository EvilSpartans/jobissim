<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\SliderRepository;
use App\Repository\SubCategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $postRepository, SubCategoriesRepository $subCategoriesRepository, SliderRepository $sliderRepository): Response
    {
        $id_emploi = $subCategoriesRepository->findOneBy(['name' => 'emploi']);
        $id_formation = $subCategoriesRepository->findOneBy(['name' => 'formation']);
        $id_cv = $subCategoriesRepository->findOneBy(['name' => 'cv']);
        $id_entreprise = $subCategoriesRepository->findOneBy(['name' => 'entreprise']);

        $emplois = $postRepository->findPostByCategory($id_emploi);
        $formations = $postRepository->findPostByCategory($id_formation);
        $cvs = $postRepository->findPostByCategory($id_cv);
        $entreprises = $postRepository->findPostByCategory($id_entreprise);
        $sliders = $sliderRepository->lastSlider();

        return $this->render('home/index.html.twig', [
            'emplois' => $emplois,
            'formations' => $formations,
            'cvs' => $cvs,
            'entreprises' => $entreprises,
            'sliders' => $sliders,
        ]);
    }
}
