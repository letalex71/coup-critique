<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SetsRepository")
 */
class Sets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pokemon", inversedBy="team")
     */
    private $pokemon;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="sets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\Column(type="text")
     */
    private $paste;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $Item;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $Ability;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $Level;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $Happiness;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Evs;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $Nature;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $Ivs;

    /**
     * @ORM\Column(type="json")
     */
    private $Moves = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPaste(): ?string
    {
        return $this->paste;
    }

    public function setPaste(string $paste): self
    {
        $this->paste = $paste;

        return $this;
    }

    public function getItem(): ?string
    {
        return $this->Item;
    }

    public function setItem(?string $Item): self
    {
        $this->Item = $Item;

        return $this;
    }

    public function getAbility(): ?string
    {
        return $this->Ability;
    }

    public function setAbility(string $Ability): self
    {
        $this->Ability = $Ability;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->Level;
    }

    public function setLevel(?string $Level): self
    {
        $this->Level = $Level;

        return $this;
    }

    public function getHappiness(): ?string
    {
        return $this->Happiness;
    }

    public function setHappiness(?string $Happiness): self
    {
        $this->Happiness = $Happiness;

        return $this;
    }

    public function getEvs(): ?string
    {
        return $this->Evs;
    }

    public function setEvs(string $Evs): self
    {
        $this->Evs = $Evs;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->Nature;
    }

    public function setNature(string $Nature): self
    {
        $this->Nature = $Nature;

        return $this;
    }

    public function getIvs(): ?string
    {
        return $this->Ivs;
    }

    public function setIvs(?string $Ivs): self
    {
        $this->Ivs = $Ivs;

        return $this;
    }

    public function getMoves(): ?array
    {
        return $this->Moves;
    }

    public function setMoves(array $Moves): self
    {
        $this->Moves = $Moves;

        return $this;
    }
}
