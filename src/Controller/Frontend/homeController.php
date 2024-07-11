<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class homeController extends AbstractController
{


    #[Route('', name: 'app.home', methods: ['GET'])]
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();

        return $this->render('frontend/home/index.html.twig', [
            'articles' => $repo->findLatestArticle(3),
        ]);
    }
}
