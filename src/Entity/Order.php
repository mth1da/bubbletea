<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")] // si on delete un user => delete tous ses orders
    private ?user $order_user = null;

    #[ORM\ManyToMany(targetEntity: Drink::class)]
    private Collection $order_drink;

    public function __construct()
    {
        $this->order_drink = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getOrderUser(): ?User
    {
        return $this->order_user;
    }

    public function setOrderUser(?User $order_user): self
    {
        $this->order_user = $order_user;

        return $this;
    }

    /**
     * @return Collection<int, drink>
     */
    public function getOrderDrink(): Collection
    {
        return $this->order_drink;
    }

    public function addOrderDrink(Drink $orderDrink): self
    {
        if (!$this->order_drink->contains($orderDrink)) {
            $this->order_drink->add($orderDrink);
        }

        return $this;
    }

    public function removeOrderDrink(Drink $orderDrink): self
    {
        $this->order_drink->removeElement($orderDrink);

        return $this;
    }
}
