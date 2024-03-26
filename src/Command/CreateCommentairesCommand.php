<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;   
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commentaires;

#[ AsCommand(
    name: 'app:create-commentaires',
    description: 'Add a short description for your command',
) ]

class CreateCommentairesCommand extends Command {
    
    private ArticlesRepository $articleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ArticlesRepository $articleRepository, EntityManagerInterface $entityManager) {
        parent::__construct();
        $this -> entityManager = $entityManager;
        $this -> articleRepository = $articleRepository;
    }

    protected function configure(): void {
        $this
        ->addArgument('nb_commentaire', InputArgument::REQUIRED, 'Nombre de commentaires')
        ->addArgument( 'id_article', InputArgument::REQUIRED, 'Id de l\'article');
    }

    protected function execute( InputInterface $input, OutputInterface $output ): int {
        $io = new SymfonyStyle( $input, $output );
        $idArticle = $input->getArgument( 'id_article' );
        $article = $this -> articleRepository -> find($idArticle);
        if(!$article){
            $io -> error('Impossible de trouver l\'article'.$idArticle);
            return Command::FAILURE;
        }

        $nbCommentaires = $input -> getArgument("nb_commentaire");
        for($compteur = 0; $compteur < $nbCommentaires; $compteur++){
            $io->comment('Creation commentaire '.$compteur);
            $commentaire = new Commentaires();
            $commentaire -> setTitle("Commentaires ".$compteur);
            $commentaire -> setDescription("Ceci est le texte de l'article ".$compteur);
            $commentaire -> setAuteur("Amandine");  
            $commentaire -> setDate(new \DateTime());
            $this->entityManager->persist($commentaire);
        }
        $this-> entityManager-> flush();
        $io->success($compteur.' Commentaire créés ! ' );

        return Command::SUCCESS;
    }
}
