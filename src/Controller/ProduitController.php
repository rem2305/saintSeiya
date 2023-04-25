<?php

namespace App\Controller;

use App\Entity\Produit;

use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/* use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; */


#[Route('/produit')]
class ProduitController extends AbstractController
{
    

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/favoris/ajout/{id}', name: 'ajout_favoris', methods: ['GET'])]
    public function ajoutFavoris(Produit $produit, EntityManagerInterface $em, ManagerRegistry $doctrine ): Response
    {
        /* if(!$produit){
            throw new NotFoundHttpException('Pas de produit trouvé');
        } */
        $produit->addFavori($this->getUser());
        $entityManager = $doctrine->getManager();

        $em = $doctrine->getManager();
        $em->persist($produit);
        $em->flush();

        return $this->redirect('app_produit_show');
    }
    
    #[Route('/favoris/retrait/{id}', name: 'retrait_favoris', methods: ['GET'])]
    public function retraitFavoris(Produit $produit, EntityManagerInterface $em, ManagerRegistry $doctrine): Response
    {
        /* if(!$produit){
            throw new NotFoundHttpException('Pas de produit trouvé');
        } */
        $produit->removeFavori($this->getUser());
        $entityManager = $doctrine->getManager();

        $em = $doctrine->getManager();
        $em->persist($produit);
        $em->flush();

        return $this->redirect('app_produit_show');
    }

}
