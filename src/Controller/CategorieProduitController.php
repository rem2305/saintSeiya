<?php

namespace App\Controller;

use App\Entity\CategorieProduit;
use App\Form\CategorieProduit1Type;
use App\Repository\CategorieProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/produit')]
class CategorieProduitController extends AbstractController
{
    #[Route('/', name: 'app_categorie_produit_index', methods: ['GET'])]
    public function index(CategorieProduitRepository $categorieProduitRepository): Response
    {
        return $this->render('categorie_produit/index.html.twig', [
            'categorie_produits' => $categorieProduitRepository->findAll(),
        ]);
    }

    
    #[Route('/{id}', name: 'app_categorie_produit_show', methods: ['GET'])]
    public function show(CategorieProduit $categorieProduit): Response
    {
        $produits = $categorieProduit->getProduits();
        return $this->render('categorie_produit/show.html.twig', [
            'categorie_produit' => $categorieProduit,
            'produits' => $produits
        ]);
    }

    
}
