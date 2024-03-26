<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(length: 255)]
    private ?string $Auteur = null;

    #[ORM\OneToMany(targetEntity: Commentaires::class, mappedBy: 'articles')]
    private Collection $Comms;

    public function __construct()
    {
        $this->Comms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

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

    public function getAuteur(): ?string
    {
        return $this->Auteur;
    }

    public function setAuteur(string $Auteur): static
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getComms(): Collection
    {
        return $this->Comms;
    }

    public function addComm(Commentaires $comm): static
    {
        if (!$this->Comms->contains($comm)) {
            $this->Comms->add($comm);
            $comm->setArticles($this);
        }

        return $this;
    }

    public function removeComm(Commentaires $comm): static
    {
        if ($this->Comms->removeElement($comm)) {
            // set the owning side to null (unless already changed)
            if ($comm->getArticles() === $this) {
                $comm->setArticles(null);
            }
        }

        return $this;
    }
}
