<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieProduit $categorieProduit = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $Prix = null;

    #[ORM\Column(length: 255)]
    private ?string $Vendeur1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Vendeur2 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Introduction = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreSecondaire = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreConclusion = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Conclusion = null;

    /* #[ORM\Column(length: 255)]
    private ?string $image = null; */

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDeCreation = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Images::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoris')]
    private Collection $favoris;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lien = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lien2 = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    /* #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 3)]
    private ?string $prix = null; */

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

    public function getCategorieProduit(): ?CategorieProduit
    {
        return $this->categorieProduit;
    }

    public function setCategorieProduit(?CategorieProduit $categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;

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

    public function getPrix(): ?string
    {
        return $this->Prix;
    }

    public function setPrix(string $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getVendeur1(): ?string
    {
        return $this->Vendeur1;
    }

    public function setVendeur1(string $Vendeur1): self
    {
        $this->Vendeur1 = $Vendeur1;

        return $this;
    }

    public function getVendeur2(): ?string
    {
        return $this->Vendeur2;
    }

    public function setVendeur2(?string $Vendeur2): self
    {
        $this->Vendeur2 = $Vendeur2;

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

    /* public function getImage(): ?string
    {
        return $this->image;
    }


    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    } */

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(\DateTimeInterface $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(User $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getLien2(): ?string
    {
        return $this->lien2;
    }

    public function setLien2(string $lien2): self
    {
        $this->lien2 = $lien2;

        return $this;
    }
}
