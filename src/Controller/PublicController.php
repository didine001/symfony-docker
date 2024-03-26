<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticlesRepository;

class PublicController extends AbstractController {
    private ArticlesRepository $articleRepository;
    private EntityManagerInterface $entityManager;

    protected function configure(): void {
        $this
        ->addArgument( 'id_article', InputArgument::REQUIRED, 'Id de l\'article');
    }

    //1 article repository a ajouter en auto wiring
    //1.5 On crée une route Accueil ( qui v aafficher lse articles )
    //2 on charge les articles
    //3 On passe les articles à la vue twig
    //4 on modifie la vue twig pour vavoir les articles visibles.
    //5 On crée une autre route Articme ( qui va afficher un article et ses commentaires )
    //6 on charge un article et ses commentaires
    // on passe les infos à la vue twig
    //o n modifie cett evue twig
    // on crée un lien dans la vue twig accueil pour aller vers la route article.
    #[ Route( '/public', name: 'app_public' ) ]

    public function index(): Response {

        return $this->render( 'public/index.html.twig', [
            'controller_name' => 'PublicController',
        ] );
        
        $article = $this -> articleRepository -> find( $idArticle );
    }
}
