<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokemonRepository")
 */
class Pokemon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $type2;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sets", mappedBy="pokemon")
     */
    private $team;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->team = new ArrayCollection();
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

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    /**
     * @return Collection|Sets[]
     */
    public function getTeam(): Collection
    {
        return $this->team;
    }

    public function addTeam(Sets $team): self
    {
        if (!$this->team->contains($team)) {
            $this->team[] = $team;
            $team->setPokemon($this);
        }

        return $this;
    }

    public function removeTeam(Sets $team): self
    {
        if ($this->team->contains($team)) {
            $this->team->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getPokemon() === $this) {
                $team->setPokemon(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return ucfirst($this->getName());
    }

}
