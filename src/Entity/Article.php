<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="idArticle")
     */
    private $orders;

    /**
     * @ORM\ManyToMany(targetEntity=Shop::class, inversedBy="articles")
     */
    private $idShop;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->idShop = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addIdArticle($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            $order->removeIdArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getIdShop(): Collection
    {
        return $this->idShop;
    }

    public function addIdShop(Shop $idShop): self
    {
        if (!$this->idShop->contains($idShop)) {
            $this->idShop[] = $idShop;
        }

        return $this;
    }

    public function removeIdShop(Shop $idShop): self
    {
        $this->idShop->removeElement($idShop);

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
