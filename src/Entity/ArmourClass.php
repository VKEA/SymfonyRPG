<?php

namespace App\Entity;

use App\Repository\ArmourClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArmourClassRepository::class)
 */
class ArmourClass
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
     * @ORM\OneToMany(targetEntity=ArmourType::class, mappedBy="class")
     */
    private $armourTypes;

    public function __construct()
    {
        $this->armourTypes = new ArrayCollection();
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

    /**
     * @return Collection|ArmourType[]
     */
    public function getArmourTypes(): Collection
    {
        return $this->armourTypes;
    }

    public function addArmourType(ArmourType $armourType): self
    {
        if (!$this->armourTypes->contains($armourType)) {
            $this->armourTypes[] = $armourType;
            $armourType->setClass($this);
        }

        return $this;
    }

    public function removeArmourType(ArmourType $armourType): self
    {
        if ($this->armourTypes->contains($armourType)) {
            $this->armourTypes->removeElement($armourType);
            // set the owning side to null (unless already changed)
            if ($armourType->getClass() === $this) {
                $armourType->setClass(null);
            }
        }

        return $this;
    }
}
