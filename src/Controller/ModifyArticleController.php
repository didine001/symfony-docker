<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\articleRepository;
class ModifyArticleController extends AbstractController
{
    private ArticlesRepository $articleRepository;
    #[Route('/modify/article/{id}', name: 'article_modify')]
   
    public function modify(int $id,ArticlesRepository $articlesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this ->articleRepository = $articlesRepository;
        $article = $this ->articleRepository-> find( $id );

        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }
    
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();
            return $this->redirectToRoute('app_accueil');
        }
    
        return $this->render('articles/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }    
}