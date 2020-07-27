<?php
// src/Entity/User.php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hitpoints;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $currentHitpoints;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $attack;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $defence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $speed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $magic;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $resistance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $accuracy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $evasion;

    /**
     * @ORM\OneToMany(targetEntity=Armour::class, mappedBy="user")
     */
    private $armours;

    /**
     * @ORM\OneToMany(targetEntity=Weapon::class, mappedBy="user")
     */
    private $weapons;

    /**
     * @ORM\OneToMany(targetEntity=ItemInventory::class, mappedBy="user")
     */
    private $itemInventories;

    /**
     * @ORM\OneToOne(targetEntity=Weapon::class, cascade={"persist", "remove"})
     */
    private $primaryWeapon;

    /**
     * @ORM\OneToOne(targetEntity=Weapon::class, cascade={"persist", "remove"})
     */
    private $secondaryWeapon;

    /**
     * @ORM\OneToOne(targetEntity=Armour::class, cascade={"persist", "remove"})
     */
    private $headArmour;

    /**
     * @ORM\OneToOne(targetEntity=Armour::class, cascade={"persist", "remove"})
     */
    private $chestArmour;

    /**
     * @ORM\OneToOne(targetEntity=Armour::class, cascade={"persist", "remove"})
     */
    private $legArmour;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->armours = new ArrayCollection();
        $this->weapons = new ArrayCollection();
        $this->itemInventories = new ArrayCollection();
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getHitpoints(): ?int
    {
        return $this->hitpoints;
    }

    public function setHitpoints(?int $hitpoints): self
    {
        $this->hitpoints = $hitpoints;

        return $this;
    }

    public function getCurrentHitpoints(): ?int
    {
        return $this->currentHitpoints;
    }

    public function setCurrentHitpoints(?int $currentHitpoints): self
    {
        $this->currentHitpoints = $currentHitpoints;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(?int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefence(): ?int
    {
        return $this->defence;
    }

    public function setDefence(?int $defence): self
    {
        $this->defence = $defence;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(?int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getMagic(): ?int
    {
        return $this->magic;
    }

    public function setMagic(?int $magic): self
    {
        $this->magic = $magic;

        return $this;
    }

    public function getResistance(): ?int
    {
        return $this->resistance;
    }

    public function setResistance(?int $resistance): self
    {
        $this->resistance = $resistance;

        return $this;
    }

    public function getAccuracy(): ?int
    {
        return $this->accuracy;
    }

    public function setAccuracy(?int $accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getEvasion(): ?int
    {
        return $this->evasion;
    }

    public function setEvasion(?int $evasion): self
    {
        $this->evasion = $evasion;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getUsername();
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
            $armour->setUser($this);
        }

        return $this;
    }

    public function removeArmour(Armour $armour): self
    {
        if ($this->armours->contains($armour)) {
            $this->armours->removeElement($armour);
            // set the owning side to null (unless already changed)
            if ($armour->getUser() === $this) {
                $armour->setUser(null);
            }
        }

        return $this;
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
            $weapon->setUser($this);
        }

        return $this;
    }

    public function removeWeapon(Weapon $weapon): self
    {
        if ($this->weapons->contains($weapon)) {
            $this->weapons->removeElement($weapon);
            // set the owning side to null (unless already changed)
            if ($weapon->getUser() === $this) {
                $weapon->setUser(null);
            }
        }

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
            $itemInventory->setUser($this);
        }

        return $this;
    }

    public function removeItemInventory(ItemInventory $itemInventory): self
    {
        if ($this->itemInventories->contains($itemInventory)) {
            $this->itemInventories->removeElement($itemInventory);
            // set the owning side to null (unless already changed)
            if ($itemInventory->getUser() === $this) {
                $itemInventory->setUser(null);
            }
        }

        return $this;
    }

    public function getPrimaryWeapon(): ?Weapon
    {
        return $this->primaryWeapon;
    }

    public function setPrimaryWeapon(?Weapon $primaryWeapon): self
    {
        $this->primaryWeapon = $primaryWeapon;

        return $this;
    }

    public function getSecondaryWeapon(): ?Weapon
    {
        return $this->secondaryWeapon;
    }

    public function setSecondaryWeapon(?Weapon $secondaryWeapon): self
    {
        $this->secondaryWeapon = $secondaryWeapon;

        return $this;
    }

    public function getHeadArmour(): ?Armour
    {
        return $this->headArmour;
    }

    public function setHeadArmour(?Armour $headArmour): self
    {
        $this->headArmour = $headArmour;

        return $this;
    }

    public function getChestArmour(): ?Armour
    {
        return $this->chestArmour;
    }

    public function setChestArmour(?Armour $chestArmour): self
    {
        $this->chestArmour = $chestArmour;

        return $this;
    }

    public function getLegArmour(): ?Armour
    {
        return $this->legArmour;
    }

    public function setLegArmour(?Armour $legArmour): self
    {
        $this->legArmour = $legArmour;

        return $this;
    }

    /**
     * JSON serialise
     */
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'level' => $this->getLevel(),
            'hitpoints' => $this->getHitpoints(),
            'currenthitpoints' => $this->getCurrentHitpoints(),
            'attack' => $this->getAttack(),
            'defence' => $this->getDefence(),
            'speed' => $this->getSpeed(),
            'magic' => $this->getMagic(),
            'resistance' => $this->getResistance(),
            'accuracy' => $this->getAccuracy(),
            'evasion' => $this->getEvasion(),
            'primaryweapon' => $this->getPrimaryWeapon(),
            'secondaryweapon' => $this->getSecondaryWeapon(),
            'headarmour' => $this->getHeadArmour(),
            'chestarmour' => $this->getChestArmour(),
            'legarmour' => $this->getLegArmour(),
        ];
    }
}