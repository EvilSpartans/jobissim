<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\PostRepository;
use App\Repository\SubCategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account_{id}", name="account")
     */
    public function index(PostRepository $postRepository, SubCategoriesRepository $subCategoriesRepository, User $user): Response
    {
        $id_emploi = $subCategoriesRepository->findOneBy(['name' => 'emploi']);
        $id_formation = $subCategoriesRepository->findOneBy(['name' => 'formation']);
        $id_cv = $subCategoriesRepository->findOneBy(['name' => 'cv']);
        $id_entreprise = $subCategoriesRepository->findOneBy(['name' => 'entreprise']);

        $posts = $postRepository->findPostByUser($user);
        $emplois = $postRepository->findPostByLikeAndCategory($id_emploi, $user);
        $formations = $postRepository->findPostByLikeAndCategory($id_formation, $user);
        $cvs = $postRepository->findPostByLikeAndCategory($id_cv, $user);
        $entreprises = $postRepository->findPostByLikeAndCategory($id_entreprise, $user);

        return $this->render('account/index.html.twig', [
            'posts' => $posts,
            'emplois' => $emplois,
            'formations' => $formations,
            'cvs' => $cvs,
            'entreprises' => $entreprises,
            'user' => $user
        ]);
    }

    /**
     * @Route("/edit_account_{id}", name="account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($user->getId() != $this->getUser()->getId()) {
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/password_account_{id}", name="account_password", methods={"GET","POST"})
     */
    public function password(Request $request, User $user, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($user->getId() != $this->getUser()->getId()) {
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account/password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
