<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;

class ArticleController extends AbstractController
{

    /**
     * @param ArticleRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route("/article", name="article_show")
     */

    // Affiche tout les articles

    public function showArticles(ArticleRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $articles = $paginator->paginate(
            $repository->findBy(array(), ['createdAt' => 'DESC']),
            $request->query->getInt('page', 1),
            4
            );
        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @param ArticleRepository $repository
     * @return JsonResponse
     * @throws ExceptionInterface
     * @Route("/search", name="search")
     */

    // Requête AJAX sur la barre de recherche en filtrant les articles par titre

    public function searchAction(Request $request, NormalizerInterface $normalizer, ArticleRepository $repository)
    {

        if ($request->isXmlHttpRequest()) {
            $research = '';
            $research = $request->get('search');
            $em = $this->getDoctrine()->getManager();

            if ($research !== '') {

                $articles = $repository->findArticlesByString($research);

                return $this->json($normalizer->normalize($articles, 200));
            }
        }
        return $this->json('error', 400);
    }

    /**
     * @Route("article/{article}", name="full_article")
     * @param Article|null $article
     * @return RedirectResponse|Response
     */
    public function readMoreArticle(Article $article = null)
    {
        if (!$article) {
            return $this->redirectToRoute('article_show');
        }
        return $this->render('article/full-article.html.twig', [
            'article' => $article,
        ]);

    }
}

