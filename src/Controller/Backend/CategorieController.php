<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categories', name:'admin.categories')]
class CategorieController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ){
        
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(CategorieRepository $repo): Response{

        $Categories = $repo->findAll();

        return $this->render('backend/Categorie/index.html.twig', [
            'categories' => $repo->findAll(),
        ]);
    }


    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // On créé un nouvel objet Categorie
        $Categorie = new Categorie();

        // On créé notre formulaire en lui passant l'objet qu'il doit remplir
        $form = $this->createForm(CategorieType::class, $Categorie);

        // On passe  la request au formulaire pour qu'il puisse récupérer les données
        $form->handleRequest($request);

        // Si le formulaire est soumis  et valide, on persiste l'objet en BDD
        if($form->isSubmitted() && $form->isValid()){
         
         
            // On met en file d'attente l'objet à persister
            $this->em->persist($Categorie);

            // On exécute la file d'attente
            $this->em->flush();
            // On créé un message flash pour informer l'utilisateur que la catégorie a bien été créée
            $this->addFlash('success', 'La catégorie a bien été créée');

            return $this->redirectToRoute('admin.categories.index');
        }
    
        return $this->render('backend/Categorie/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods:['GET', 'POST'])]
    public function update(?Categorie $categorie, Request $request): Response{

        if (!$categorie) {
            $this->addFlash('error', 'La catégorie demandée n\'existe pas');

            return $this->redirectToRoute('admin.categorie.index');
        }

        // Pour que le formulaire soit pré-rempli, on procède par ces étapes ci-dessous
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest(request: $request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categorie);
            $this->em->flush();

            $this->addFlash('Success', 'La catégorie a été modifiée');

            return $this->redirectToRoute('admin.categories.index');
        }

        return $this->render('backend/Categorie/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Categorie $Categorie, Request $request): RedirectResponse{

        if(!$Categorie){
            $this->addFlash('error', 'La catégorie demandée n\'existe pas');

            return $this->redirectToRoute('admin.categories.index');
        }


        if ($this->isCsrfTokenValid('delete'.$Categorie->getId(), $request->request->get('token'))) {
           $this->em->remove($Categorie);
           
           $this->em->flush();

           $this->addFlash('Success', 'La catégorie a bien été supprimée');
        }
        else{
            $this->addFlash('Error', 'Le jeton CSRF est invalide');
        }
        return $this->redirectToRoute('admin.categories.index');

    }
}
