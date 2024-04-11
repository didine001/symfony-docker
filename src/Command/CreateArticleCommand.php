<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Articles;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[ AsCommand(
    name: 'app:create-articles',
    description: 'Create article',
) ]

class CreateArticleCommand extends Command {
    private EntityManagerInterface $entityManager;

    public function __construct( EntityManagerInterface $entityManager ) {
        parent::__construct();
        $this-> entityManager = $entityManager;
    }

    protected function configure(): void {
        $this
        ->addArgument( 'nb_articles', InputArgument::OPTIONAL, 'Nombre d\'articles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nb_articles = $input->getArgument('nb_articles');
        $io -> warning("Creation de ".$nb_articles.' articles');
        if($nb_articles < 1 ) return Command::FAILURE;

        for($compteur =0 ; $compteur < $nb_articles; $compteur++){
            $io -> comment("Création article '.$compteur");
            $article = new Articles();
            $article -> setTitle("Article numéro ".$compteur);
            $article -> setDescription("Ceci est le texte de l'article ".$compteur);
            $article -> setAuteur("Amandine");  
            $article -> setDate(new \DateTime());
            $this -> entityManager ->persist($article);
        }
        $this-> entityManager-> flush();
        $io->success($compteur.' Articles créés ! ' );

        return Command::SUCCESS;
    }
}
