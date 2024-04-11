<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentairesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommentairesController extends AbstractController {
    #[ Route( '/commentaires/create', name: 'comment_create', methods: [ 'POST' ] ) ]

    public function create( Request $request, EntityManagerInterface $entityManager ): Response {
        $commentaire = new Commentaires();
        $form = $this->createForm( CommentairesType::class, $commentaire );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $description = $form->get('Description')->getData();
            $date = $form->get('Date')->getData();
            $auteur = $form->get('Auteur')->getData();
            $titre = $form->get('Title')->getData();
            $article = $form->get('articles')->getData();
            $commentaire->setDescription($description);
            $commentaire->setDate($date);
            $commentaire->setAuteur($auteur);
            $commentaire->setTitle($titre);
            $commentaire->setArticles($article);
            $entityManager->persist( $commentaire );
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('commentaires/index.html.twig', [
            'form' => $form->createView(),
        ] );
    }
}
