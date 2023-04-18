<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrinkRepository::class)]
class Drink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $flavour = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToMany(targetEntity: Popping::class)]
    private Collection $drink_popping;

    public function __construct()
    {
        $this->drink_popping = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlavour(): ?string
    {
        return $this->flavour;
    }

    public function setFlavour(string $flavour): self
    {
        $this->flavour = $flavour;

        return $this;
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, popping>
     */
    public function getDrinkPopping(): Collection
    {
        return $this->drink_popping;
    }

    public function addDrinkPopping(Popping $drinkPopping): self
    {
        if (!$this->drink_popping->contains($drinkPopping)) {
            $this->drink_popping->add($drinkPopping);
        }

        return $this;
    }

    public function removeDrinkPopping(Popping $drinkPopping): self
    {
        $this->drink_popping->removeElement($drinkPopping);

        return $this;
    }
}
