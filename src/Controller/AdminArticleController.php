<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/article')]
class AdminArticleController extends AbstractController
{
    #[Route('/', name: 'app_admin_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin_article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setDateDeCreation(new DateTime("now"));
            // on récupère l'image du formulaire
            $file = $form->get('imageForm')->getData();
            if ($file){ // on traite l'image uniquement s'il y a une image d'ajoutée dans le formulaire sinon on ne fait rien
                // on renomme l'image en mettant le titre sous forme de slug en ajoutant un uniqid puis l'extension de l'image
                // slug : transforme une chaine de caractère ex: "mot clé" => "mot-cle"
                $fileName = $slugger->slug($article->getTitle() ) . uniqid() . '.' . $file->guessExtension();

                try{
                    // on déplace l'image dans le dossier paramétré dans config/service.yaml avec le nom créé ($fileName)
                    $file->move($this->getParameter('article_image'), $fileName);
                } catch(FileException $e){
                    // gérer les exceptions en cas d'erreur
                }
                // on affecte le nom de l'image à l'article que l'on va enregistrer en bdd
                $article->setImage($fileName);
            }
            $manager = $doctrine->getManager();
            $manager->persist($article);
            $manager->flush();
            /* $articleRepository->save($article, true); */

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }



    #[Route('/{id}', name: 'app_admin_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('admin_article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDateDeCreation(new DateTime("now"));
            $file = $form->get('imageForm')->getData();
            if ($file){ 
                $fileName = $slugger->slug($article->getTitle() ) . uniqid() . '.' . $file->guessExtension();

                try{
                    $file->move($this->getParameter('article_image'), $fileName);
                } catch(FileException $e){
                }
                $article->setImage($fileName);
            }
            $manager = $doctrine->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
