<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticlesRepository;
use App\Repository\CommentairesRepository;

class PublicController extends AbstractController {

    //1 article repository a ajouter en auto wiring.
    //1.5 On crée une route Accueil ( qui va afficher les articles ).
    //2 on charge les articles.
    //3 On passe les articles à la vue twig.
    //4 On modifie la vue twig pour avoir les articles visibles.
    //5 On crée une autre route Articme ( qui va afficher un article et ses commentaires ).
    //6 On charge un article et ses commentaires.
    //7 On passe les infos à la vue twig.
    //8 On modifie cett evue twig.
    //9 On crée un lien dans la vue twig accueil pour aller vers la route article.

    private ArticlesRepository $articleRepository;

    public function __construct( ArticlesRepository $articleRepository, CommentairesRepository $commentaireRepository) {
        $this -> articleRepository = $articleRepository;
        $this -> commentaireRepository = $commentaireRepository;
    }

    #[ Route( '/', name: 'app_accueil' ) ]
    #[ Route( '/article/{id}', name: 'app_article' ) ]

    public function index(): Response {
        $articles = $this -> articleRepository -> findAll();
        return $this->render( 'public/index.html.twig', [
            'articles' => $articles
        ] );
    }

    public function article( int $id ): Response {
        $article = $this -> articleRepository -> find( $id );
        $comms = $this ->  commentaireRepository -> findAll();
        return $this->render( 'public/article.html.twig', [
            'article' => $article,
            'comms' => $comms
        ] );
    }
}
