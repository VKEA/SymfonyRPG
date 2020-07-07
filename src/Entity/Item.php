<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $effects;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sprite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reusable;

    /**
     * @ORM\OneToMany(targetEntity=ItemInventory::class, mappedBy="item")
     */
    private $itemInventories;

    public function __construct()
    {
        $this->itemInventories = new ArrayCollection();
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

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getEffects(): ?string
    {
        return $this->effects;
    }

    public function setEffects(?string $effects): self
    {
        $this->effects = $effects;

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

    public function getSprite(): ?string
    {
        return $this->sprite;
    }

    public function setSprite(?string $sprite): self
    {
        $this->sprite = $sprite;

        return $this;
    }

    public function getReusable(): ?bool
    {
        return $this->reusable;
    }

    public function setReusable(?bool $reusable): self
    {
        $this->reusable = $reusable;

        return $this;
    }

    /**
     * @return Collection|ItemInventory[]
     */
    public function getItemInventories(): Collection
    {
        return $this->itemInventories;
    }

    public function addItemInventory(ItemInventory $itemInventory): self
    {
        if (!$this->itemInventories->contains($itemInventory)) {
            $this->itemInventories[] = $itemInventory;
            $itemInventory->setItem($this);
        }

        return $this;
    }

    public function removeItemInventory(ItemInventory $itemInventory): self
    {
        if ($this->itemInventories->contains($itemInventory)) {
            $this->itemInventories->removeElement($itemInventory);
            // set the owning side to null (unless already changed)
            if ($itemInventory->getItem() === $this) {
                $itemInventory->setItem(null);
            }
        }

        return $this;
    }
}
