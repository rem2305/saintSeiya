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
        //je récupère la recherche tapée avec le query puis le get. 
        //Le 'search' est le résultat de la recherche tapée dans le fichier html.twig
        $search = $request->query->get('search');
        /* dd($search); */
        
        //Maintenant j'oriente ma recherche sur les articles présents base de données
        $articles = $articleRepository->findBySearch($search);
        /* dd($articles); */
        $produits = $produitRepository->findBySearch($search);

        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'articles' => $articles,
            'produits' => $produits
            
        ]);
    }
}
