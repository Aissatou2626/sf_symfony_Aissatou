<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class listArticlesController extends AbstractController
{
    #[Route('/listArticles', name: 'app.home.listArticle', methods: ['GET'])]
    public function index(ArticleRepository $repo): Response
    {
       
        return $this->render('frontend/listArticles/index.html.twig', [
            'articles' => $repo->findBy(['enable' => true], ['createdAt' => 'DESC'])
        ]);
    }

    #[Route('/{id}infosArticle', name: 'app.home.infosArticle', methods:['GET'])]
    public function infosArticle(?Article $article): Response|RedirectResponse{
        if (!$article || !$article->isEnable()) {
            $this->addFlash('error', 'Article non trouvé');

            return $this->redirectToRoute('app.home.infosArticle');
           
        }
        return $this->render('frontend/listArticles/infosArticle.html.twig', [
            'article' => $article,
        ]);
    }
}
