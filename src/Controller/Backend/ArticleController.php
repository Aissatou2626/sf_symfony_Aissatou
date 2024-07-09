<?php

namespace App\Controller\Backend;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin/article', name: 'admin.article')]
class ArticleController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(ArticleRepository $repo): Response
    {
        // Pour le Read du CRUD
        $articles =  $repo->findAll();
        return $this->render('backend/article/index.html.twig', [
            'articles' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $article = new Article();

        // On créé notre formulaire en lui passant l'objet qu'il doit remplir
        $form = $this->createForm(ArticleType::class, $article);


        // On passe  la request au formulaire pour qu'il puisse récuopérer les données
        $form->handleRequest($request);

        // Si le formulaire est soumis  et valide, on persiste l'objet en BDD
        if ($form->isSubmitted() && $form->isValid()) {
            // En faisant ça( $this->getUser()), on récupère l'utilisateur connecté actuellement
            $user = $this->getUser();
            $article->setUser($user);

            // On met en file d'attente l'objet à persister
            $this->em->persist($article);

            // On exécute la file d'attente
            $this->em->flush();
            // On créé un message flash pour informer l'utilisateur que la catégorie a bien été créée
            $this->addFlash('success', 'L\'article a bien été créée');

            return $this->redirectToRoute('admin.article.index');
        }
        return $this->render('backend/article/create.html.twig', [
            'form' => $form,
        ]);
    }
    //Pour modifer un ou plusieurs article(s)
    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    // Le param converter dans notre cas est : (?article $article, Request $request)
    public function update(?article $article, Request $request): Response|RedirectResponse
    {

        if (!$article) {
            $this->addFlash('error', 'L\'article demandé n\'existe pas');

            return $this->redirectToRoute('admin.article.index');
        }
        // On va créer un formulaire et on lui passe la requête
        $form = $this->createForm(articleType::class, $article);
        $form->handleRequest(request: $request);

        if ($form->isSubmitted() && $form->isValid()) {
            //On fait appelle à  entityManagerInterface($em) qui correspond à la persistance des données
            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash('Success', 'L\'article a été modifié');

            // redirectToRoute() permet de rediriger vers une page 
            return $this->redirectToRoute('admin.article.index');
        }
        // render() permet d'afficher une page html 
        return $this->render('backend/article/update.html.twig', [
            'form' => $form]);

    }

    // Delete
    #[Route('/{id}/delete', name:'.delete', methods: ['POST'])]
    public function delete(?article $article, Request $request): RedirectResponse{
        if (!$article) {
            $this->addFlash('error', 'L\'article demandé n\'existe pas');

            return $this->redirectToRoute('admin.article.index');
        }

        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('token'))) {
            $this->em->remove($article);
            $this->em->flush();

            $this->addFlash('success', 'Article supprimé avec succès');
        } else {
            $this->addFlash('error', 'Token CSRF invalide');
        }
        return $this->redirectToRoute('admin.article.index');
    } 
}
