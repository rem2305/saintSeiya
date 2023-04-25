<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Produit;
use App\Form\Produit2Type;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit/images')]
class ProduitImagesController extends AbstractController
{
    #[Route('/', name: 'app_produit_images_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit_images/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_images_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(Produit2Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $produitRepository->save($produit, true); */
            // on récupère les images transmises
            $images = $form->get('images')->getData();

            //on boucle sur les images 
            foreach($images as $image){
                // on génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // on copie le fichier dans le dossier imagesProduit
                $image->move(
                    $this->getParameter('produit_image'),
                    $fichier 
                );
                // on stocke l'image dans la BDD (son nom)
                $img = new Images();
                $img->setName($fichier);
                $produit->addImage($img);
            }


            return $this->redirectToRoute('app_produit_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit_images/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_images_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit_images/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(Produit2Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit_images/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_images_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_images_index', [], Response::HTTP_SEE_OTHER);
    }
}
