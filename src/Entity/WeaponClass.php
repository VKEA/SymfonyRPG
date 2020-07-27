<?php

namespace App\Entity;

use App\Repository\WeaponClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeaponClassRepository::class)
 */
class WeaponClass implements \JsonSerializable
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
     * @ORM\OneToMany(targetEntity=WeaponType::class, mappedBy="class")
     */
    private $weaponTypes;

    public function __construct()
    {
        $this->weaponTypes = new ArrayCollection();
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

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * @return Collection|WeaponType[]
     */
    public function getWeaponTypes(): Collection
    {
        return $this->weaponTypes;
    }

    public function addWeaponType(WeaponType $weaponType): self
    {
        if (!$this->weaponTypes->contains($weaponType)) {
            $this->weaponTypes[] = $weaponType;
            $weaponType->setClass($this);
        }

        return $this;
    }

    public function removeWeaponType(WeaponType $weaponType): self
    {
        if ($this->weaponTypes->contains($weaponType)) {
            $this->weaponTypes->removeElement($weaponType);
            // set the owning side to null (unless already changed)
            if ($weaponType->getClass() === $this) {
                $weaponType->setClass(null);
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
            'name' => $this->getName()
        ];
    }
}
