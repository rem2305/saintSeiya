<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Produit;
use App\Repository\ArticleRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, ProduitRepository $produitRepository, ArticleRepository $articleRepository)
    {
        /* $article = $doctrine->getRepository(Article::class)->findBy([], ["dateDeCreation" => 'desc']);
        $produit = $doctrine->getRepository(Produit::class)->findBy([], ["dateDeCreation" => "desc"]); */
        
        /* dd($article); */

        return $this->render('home/index.html.twig', [
            /* 'controller_name' => 'HomeController', */
            'articles' => $articleRepository->findAll(),/* ->findBy (['dateDeCreation' => 'DESC']) */
            'produits' => $produitRepository->findAll()/* ->findBy (['dateDeCreation' => 'DESC']) */
        ]);
    }
    
}
