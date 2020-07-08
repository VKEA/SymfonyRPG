<?php

namespace App\Entity;

use App\Repository\WeaponTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeaponTypeRepository::class)
 */
class WeaponType implements \JsonSerializable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $power;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $effects;

    /**
     * @ORM\ManyToOne(targetEntity=WeaponClass::class, inversedBy="weaponTypes")
     */
    private $class;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxDurability;

    /**
     * @ORM\OneToMany(targetEntity=Weapon::class, mappedBy="type")
     */
    private $weapons;

    public function __construct()
    {
        $this->weapons = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(?int $power): self
    {
        $this->power = $power;

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

    public function getClass(): ?WeaponClass
    {
        return $this->class;
    }

    public function setClass(?WeaponClass $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getMaxDurability(): ?int
    {
        return $this->maxDurability;
    }

    public function setMaxDurability(?int $maxDurability): self
    {
        $this->maxDurability = $maxDurability;

        return $this;
    }
    
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * @return Collection|Weapon[]
     */
    public function getWeapons(): Collection
    {
        return $this->weapons;
    }

    public function addWeapon(Weapon $weapon): self
    {
        if (!$this->weapons->contains($weapon)) {
            $this->weapons[] = $weapon;
            $weapon->setType($this);
        }

        return $this;
    }

    public function removeWeapon(Weapon $weapon): self
    {
        if ($this->weapons->contains($weapon)) {
            $this->weapons->removeElement($weapon);
            // set the owning side to null (unless already changed)
            if ($weapon->getType() === $this) {
                $weapon->setType(null);
            }
        }

        return $this;
    }

    /**
     * JSON serialise
     */
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'power' => $this->getPower(),
            'effects' => $this->getEffects(),
            'class' => $this->getClass(),
            'maxdurability' => $this->getMaxDurability(),
            'weapons' => $this->getWeapons(),
        ];
    }
}
