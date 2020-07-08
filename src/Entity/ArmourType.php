<?php

namespace App\Entity;

use App\Repository\ArmourTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArmourTypeRepository::class)
 */
class ArmourType
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
    private $protection;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $effects;

    /**
     * @ORM\ManyToOne(targetEntity=ArmourClass::class, inversedBy="armourTypes")
     */
    private $class;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxDurability;

    /**
     * @ORM\OneToMany(targetEntity=Armour::class, mappedBy="type")
     */
    private $armours;

    public function __construct()
    {
        $this->armours = new ArrayCollection();
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

    public function getProtection(): ?int
    {
        return $this->protection;
    }

    public function setProtection(?int $protection): self
    {
        $this->protection = $protection;

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

    public function getClass(): ?ArmourClass
    {
        return $this->class;
    }

    public function setClass(?ArmourClass $class): self
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
     * @return Collection|Armour[]
     */
    public function getArmours(): Collection
    {
        return $this->armours;
    }

    public function addArmour(Armour $armour): self
    {
        if (!$this->armours->contains($armour)) {
            $this->armours[] = $armour;
            $armour->setType($this);
        }

        return $this;
    }

    public function removeArmour(Armour $armour): self
    {
        if ($this->armours->contains($armour)) {
            $this->armours->removeElement($armour);
            // set the owning side to null (unless already changed)
            if ($armour->getType() === $this) {
                $armour->setType(null);
            }
        }

        return $this;
    }
}
