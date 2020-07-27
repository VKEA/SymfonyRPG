<?php

namespace App\Entity;

use App\Repository\ArmourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArmourRepository::class)
 */
class Armour implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity=ArmourType::class, inversedBy="armours")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="armours")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $durability;

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

    public function getType(): ?ArmourType
    {
        return $this->type;
    }

    public function setType(?ArmourType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDurability(): ?int
    {
        return $this->durability;
    }

    public function setDurability(?int $durability): self
    {
        $this->durability = $durability;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * JSON serialise
     */
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'user' => $this->getUser()->getId(),
            'durability' => $this->getDurability()
        ];
    }
}
