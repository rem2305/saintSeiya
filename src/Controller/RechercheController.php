<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request, ArticleRepository $articleRepository, ProduitRepository $produitRepository): Response
    {
        $search = $request->query->get('search');
        
        $articles = $articleRepository->findBySearch($search);
        $produits = $produitRepository->findBySearch($search);

        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'articles' => $articles,
            'produits' => $produits
            
        ]);
    }
}
