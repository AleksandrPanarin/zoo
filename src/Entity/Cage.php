<?php

namespace App\Entity;

use App\Repository\CageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass=CageRepository::class)
 */
class Cage
{
    public const ACTION_CLEAR_CAGE = 1;
    public const ACTION_FREE_ANIMAL = 2;
    public const ACTION_ADD_ANIMAL = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="Animal", mappedBy="cage", cascade={"persist"})
     */
    private $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if ($this->animals->count() && !$this->isValidAnimalType($animal)) {
            throw new Exception('Cage can contain only one animal type');
        }

        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setCage($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getCage() === $this) {
                $animal->setCage(null);
            }
        }

        return $this;
    }

    public function isValidAnimalType(Animal $animal)
    {
        $class = $this->animals->current()->type();
        return $animal instanceof $class;
    }
}
