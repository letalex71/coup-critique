<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $explanations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $validated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tier", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sets", mappedBy="team", orphanRemoval=true)
     */
    private $sets;


    public function __construct()
    {
        $this->sets = new ArrayCollection();
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

    public function getExplanations(): ?string
    {
        return $this->explanations;
    }

    public function setExplanations(?string $explanations): self
    {
        $this->explanations = $explanations;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getValidated(): ?string
    {
        return $this->validated;
    }

    public function setValidated(string $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getTier(): ?Tier
    {
        return $this->tier;
    }

    public function setTier(?Tier $tier): self
    {
        $this->tier = $tier;

        return $this;
    }


    /**
     * @return Collection|Sets[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(Sets $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
            $set->setTeam($this);
        }

        return $this;
    }

    public function removeSet(Sets $set): self
    {
        if ($this->sets->contains($set)) {
            $this->sets->removeElement($set);
            // set the owning side to null (unless already changed)
            if ($set->getTeam() === $this) {
                $set->setTeam(null);
            }
        }

        return $this;
    }

}
