<?php

namespace App\Controller;

use DateTime;
use App\Entity\Images;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Service\PictureService;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/admin/produit')]
class AdminProduitController extends AbstractController
{
    #[Route('/', name: 'app_admin_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin_produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository, EntityManagerInterface $em, SluggerInterface $slugger, ManagerRegistry $doctrine, PictureService $pictureService): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $produitRepository->save($produit, true); */
            $produit->setDateDeCreation(new DateTime("now"));
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
            $manager = $doctrine->getManager();
            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('admin_produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setDateDeCreation(new DateTime("now"));
            
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
            $manager = $doctrine->getManager();
            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/supprime/image/{id}', name: 'produit_delete_image', methods: ['DELETE'])]
    public function deleteImage(Images $image, Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine){
        $data = json_decode($request->getContent(), true);
        
        // on vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            //onrécupère le nom de l'image
            $nom = $image->getName();
            // on supprime le fichier
            unlink($this->getParameter('produit_image'.'/'.$nom));

            // on supprime l'entrée de la base
            /* $em = $doctrine->getManager(); */
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
           
            // on répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
