<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieArticle $categorieArticle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Introduction = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreSecondaire = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreConclusion = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Conclusion = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDeCreation = null;

    /* #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categorie $categorie = null; */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   /*  public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    } */

   public function getCategorieArticle(): ?CategorieArticle
   {
       return $this->categorieArticle;
   }

   public function setCategorieArticle(?CategorieArticle $categorieArticle): self
   {
       $this->categorieArticle = $categorieArticle;

       return $this;
   }

   public function getIntroduction(): ?string
   {
       return $this->Introduction;
   }

   public function setIntroduction(string $Introduction): self
   {
       $this->Introduction = $Introduction;

       return $this;
   }

   public function getTitreSecondaire(): ?string
   {
       return $this->TitreSecondaire;
   }

   public function setTitreSecondaire(string $TitreSecondaire): self
   {
       $this->TitreSecondaire = $TitreSecondaire;

       return $this;
   }

   public function getTitreConclusion(): ?string
   {
       return $this->TitreConclusion;
   }

   public function setTitreConclusion(string $TitreConclusion): self
   {
       $this->TitreConclusion = $TitreConclusion;

       return $this;
   }

   public function getConclusion(): ?string
   {
       return $this->Conclusion;
   }

   public function setConclusion(string $Conclusion): self
   {
       $this->Conclusion = $Conclusion;

       return $this;
   }

   public function getImage(): ?string
   {
       return $this->Image;
   }

   public function setImage(string $Image): self
   {
       $this->Image = $Image;

       return $this;
   }

   public function getDateDeCreation(): ?\DateTimeInterface
   {
       return $this->dateDeCreation;
   }

   public function setDateDeCreation(\DateTimeInterface $dateDeCreation): self
   {
       $this->dateDeCreation = $dateDeCreation;

       return $this;
   }
}
