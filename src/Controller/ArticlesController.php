<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Articles;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'article_create')]
    
    public function create( Request $request, EntityManagerInterface $entityManager ): Response {
        $article = new Articles();
        $form = $this->createForm( ArticleType::class, $article );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $description = $form->get('Description')->getData();
            $date = $form->get('Date')->getData();
            $auteur = $form->get('Auteur')->getData();
            $titre = $form->get('Title')->getData();
            $article->setDescription($description);
            $article->setDate($date);
            $article->setAuteur($auteur);
            $article->setTitle($titre);
            $entityManager->persist( $article );
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('articles/index.html.twig', [
            'form' => $form->createView(),
        ] );
    }
}
