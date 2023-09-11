<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 */
class Restaurant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $openHours;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dish", mappedBy="restaurant")
     * @ORM\JoinColumn(nullable=true)
     */
    private $dishes;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="restaurant")
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurateur", inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $restaurateur;

    public function __construct()
    {
        $this->creationDate = new \DateTime("now"); //La date de création du restaurant est renseignée dès la création de l'objet
        $this->plats = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    public function getPicture(string $type): string{
        //Cette fonction rend une image illustrant le restaurant selon la catégorie de ce dernier
        return strtolower($this->getCategory()->getName()) . '_' . $type . '.jpg';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOpenHours(): ?string
    {
        return $this->openHours;
    }

    public function setOpenHours(string $openHours): self
    {
        $this->openHours = $openHours;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setRestaurant($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getRestaurant() === $this) {
                $commande->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dish[]
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes[] = $dish;
            $dish->setRestaurant($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getRestaurant() === $this) {
                $dish->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getRestaurateur(): ?Restaurateur
    {
        return $this->restaurateur;
    }

    public function setRestaurateur(?Restaurateur $restaurateur): self
    {
        $this->restaurateur = $restaurateur;

        return $this;
    }

}
