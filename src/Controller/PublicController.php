<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticlesRepository;
use App\Repository\CommentairesRepository;

class PublicController extends AbstractController {
    private ArticlesRepository $articleRepository;
    private CommentairesRepository $commentairesRepository;
    public function __construct( ArticlesRepository $articleRepository, CommentairesRepository $commentairesRepository) {
        $this ->articleRepository= $articleRepository;
        $this ->commentairesRepository= $commentairesRepository;
    }

    #[ Route( '/', name: 'app_accueil' ) ]
    public function index(): Response {
        $articles = $this -> articleRepository -> findAll();
        return $this->render( 'public/index.html.twig', [
            'articles' => $articles
        ] );
    }
    
    #[ Route( '/article/{id}', name: 'app_article' ) ]
    public function article( int $id ): Response {
        $article = $this ->articleRepository-> find( $id );
        $comms = $this ->commentairesRepository-> findAll();
        return $this->render( 'public/article.html.twig', [
            'article' => $article,
            'comms' => $comms
        ] );
    }
}
