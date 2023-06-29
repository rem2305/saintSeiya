<?php

namespace App\Controller;

use App\Entity\CategorieArticle;
use App\Form\CategorieArticle1Type;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categorie/article')]
class CategorieArticleController extends AbstractController
{
    #[Route('/', name: 'app_categorie_article_index', methods: ['GET'])]
    public function index(CategorieArticleRepository $categorieArticleRepository): Response
    {
        return $this->render('categorie_article/index.html.twig', [
            'categorie_articles' => $categorieArticleRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_article_show', methods: ['GET'])]
    public function show(CategorieArticle $categorieArticle): Response
    {
        $articles = $categorieArticle->getArticles();
        return $this->render('categorie_article/show.html.twig', [
            'categorie_article' => $categorieArticle,
            'articles' => $articles
        ]);
    }  

}
