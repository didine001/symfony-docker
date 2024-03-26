<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ ORM\Entity( repositoryClass: CommentairesRepository::class ) ]

class Commentaires {
    #[ ORM\Id ]
    #[ ORM\GeneratedValue ]
    #[ ORM\Column ]
    private ?int $id = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $Description = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $Auteur = null;

    #[ORM\ManyToOne(inversedBy: 'Comms')]
    private ?Articles $articles = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getDescription(): ?string {
        return $this->Description;
    }

    public function setDescription( string $Description ): static {
        $this->Description = $Description;

        return $this;
    }

    public function getAuteur(): ?string {
        return $this->Auteur;
    }

    public function setAuteur( string $Auteur ): static {
        $this->Auteur = $Auteur;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): static
    {
        $this->articles = $articles;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }
}
