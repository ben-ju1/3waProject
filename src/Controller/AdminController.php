<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CategoryAddType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Service\UploaderHelper;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/lr-adm", name="admin_home")
     * @param PaginatorInterface $paginator
     * @param ArticleRepository $repository
     * @param Request $request
     * @return Response
     */

    // Affiche tout les articles sur la première page du panel admin

    public function adminHome(PaginatorInterface $paginator, ArticleRepository $repository, Request $request)
    {
        $articles = $paginator->paginate(
            $repository->findAllOrderByDesc(),
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('admin/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @param Request $request
     * @param Article|null $article
     * @param UploaderHelper $uploaderHelper
     * @return mixed
     * @throws \Exception
     * @Route("/lr-adm/article/add", name="admin_article_add")
     * @Route("/lr-adm/article/edit/{article}", name="admin_article_edit")
     */

    // Gère l'ajout des nouveaux articles et l'édition d'articles déjà existants

    public function formArticle(Request $request, Article $article = null, UploaderHelper $uploaderHelper)
    {
        $isEdit = false;
        if ($article === null) {
            $article = new Article();
            $editMode = false;
        }
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $form = $this->createForm(ArticleType::class, $article);
        $manager = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
//            Verification qu'une photo a été posté
            if ($uploadedFile !== null) {
//           Suppression ancienne image seulement si une nouvelle photo a été posté
//                et si l'article est déjà existant
                if ($article->getId()) {
                    $uploaderHelper->deleteFile($article);
                }
                $newFileName = $uploaderHelper->uploadFile($uploadedFile);
//           Ajout nouvelle image
                $article->setImage($newFileName);
            }
            if ($article->getId()) {
                $isEdit = true;
                $article->setEditedAt(new \DateTime());
                $this->addFlash('success', "Les modifications ont bien été sauvegardées!");

            } else {
                $article->setCreatedAt(new \DateTime());
                $this->addFlash('success', "Votre article a bien été crée!");
            }
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/add-article.html.twig', [
            'formArticle' => $form->createView(),
            'article' => $article,
            'isEdit' => $isEdit,
        ]);
    }

    /**
     * @param Article $article
     * @param UploaderHelper $uploaderHelper
     * @return RedirectResponse
     * @Route("/lr-adm/article/remove/{article}", name="admin_article_delete")
     */

    // Suppression d'un article depuis le panel admin

    public function deleteArticle(Article $article, UploaderHelper $uploaderHelper)
    {
        $manager = $this->getDoctrine()->getManager();

        $uploaderHelper->deleteFile($article);
        $manager->remove($article);
        $manager->flush();
        $this->addFlash('success', "L'article a bien été supprimé");

        return $this->redirectToRoute('admin_home');
    }

    /**
     * @Route("/lr-adm/utilisateurs/{user}", name="admin_user_management")
     */
    public function userManagement(User $user = null, PaginatorInterface $paginator, Request $request, UserRepository $repository)
    {
//        Gestion de la requete 'roles' qui permet de changer le role pour chaque utilisateur
        if ($request->isMethod('POST')) {
            switch ($request->request->get('roles')) {
                case 'ROLE_USER':
                    $tmpRole = '["ROLE_USER"]';
                    break;
                case 'ROLE_VERIFIED':
                    $tmpRole = '["ROLE_VERIFIED"]';
                    break;
                case 'ROLE_ADMIN':
                    $tmpRole = '["ROLE_ADMIN"]';
                    break;
            }
            if (!isset($tmpRole)) {
                return new Response('Le role n\'existe pas');
            }
            $repository->changeRoleUser($tmpRole, $user->getId());
            $this->addFlash('success', 'Le role de l\'utilisateur à bien été modifié');
            return $this->redirectToRoute('admin_user_management');
        }
        // Si l'id d'utilisateur n'est pas passé on affiche l'ensemble des utilisateurs
        if ($user === null) {
            $users = $paginator->paginate(
                $repository->findAllOrderByDesc(),
                $request->query->getInt('page', 1),
                4
            );
            return $this->render('admin/users.html.twig', [
                'users' => $users,
            ]);
        }
        // Sinon on display uniquement l'utilisateur passé dans la requete par l'ID {user}
        return $this->render('admin/users.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @param User $user
     * @return RedirectResponse
     * @Route("/lr-adm/utilisateur/remove/{user}", name="admin_user_delete")
     */

    // Suppression d'un utilisateur depuis le panel admin

    public function deleteUser(User $user)
    {
        $manager = $this->getDoctrine()->getManager();
        $tokens = $user->getTokens();
        if (!$tokens->isEmpty()) {
            foreach ($tokens->toArray() as $token) {
                $manager->remove($token);
            }
        }
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', "L'utilisateur a bien été supprimé");

        return $this->redirectToRoute('admin_user_management');
    }

    /**
     * @Route("lr-adm/categorie/add", name="admin_category_add")
     * @param Request $request
     * @return Response
     */
    // Création d'une nouvelle catégorie
    public function addCategory(Request $request)
    {
        $category = new Category();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Une nouvelle catégorie à bien été ajoutée');
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/category/category.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("lr-adm/categorie/remove/{category}", name="admin_category_delete")
     */
    public function removeCategory(Category $category = null, CategoryRepository $repository)
    {
        if ($category === null) {
            $categories = $repository->findAll();
            return $this->render('admin/category/remove-category.html.twig', [
                'categories' => $categories,
            ]);
        }
        $category = $repository->findOneBy(['id' => $category->getId()]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'La catégorie a bien été supprimée');
        return $this->redirectToRoute('admin_home');
    }
}
