<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $players;

    /**
     * @ORM\Column(type="integer")
     */
    private $turn;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="currentTurnGames")
     */
    private $currentPlayer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayers(): ?string
    {
        return $this->players;
    }

    public function setPlayers(string $players): self
    {
        $this->players = $players;

        return $this;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getCurrentPlayer(): ?User
    {
        return $this->currentPlayer;
    }

    public function setCurrentPlayer(?User $currentPlayer): self
    {
        $this->currentPlayer = $currentPlayer;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
