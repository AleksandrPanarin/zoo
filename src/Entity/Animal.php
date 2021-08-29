<?php

namespace App\Entity;

use App\Entity\Animals\Crocodile;
use App\Entity\Animals\Elephant;
use App\Entity\Animals\Lion;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnimalRepository;
use Exception;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"animal" = "Animal",
 *     "lion" = "App\Entity\Animals\Lion",
 *     "crocodile" = "App\Entity\Animals\Crocodile",
 *     "elephant" = "App\Entity\Animals\Elephant",
 * })
 */
abstract class Animal
{
    public const ACTION_EAT = 1;
    public const ACTION_GROWL = 2;
    public const ACTION_SWIMMING = 3;
    public const ACTION_FUNNY = 4;

    private const ACTIONS_METHODS = [
        self::ACTION_EAT => 'eat',
        self::ACTION_GROWL => 'growl',
        self::ACTION_SWIMMING => 'swimming',
        self::ACTION_FUNNY => 'wateringMyselfWithTrunk',
    ];

    public const ACTIONS_CLASSES = [
        self::ACTION_EAT => 'btn-outline-success',
        self::ACTION_GROWL => 'btn-outline-warning',
        self::ACTION_SWIMMING => 'btn-outline-primary',
        self::ACTION_FUNNY => 'btn-outline-info',
    ];

    public const ACTIONS_NAMES = [
        self::ACTION_EAT => 'EAT',
        self::ACTION_GROWL => 'GROWL',
        self::ACTION_SWIMMING => 'SWIMMING',
        self::ACTION_FUNNY => 'FUNNY',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cage", inversedBy="animals")
     */
    private $cage;

    public abstract function eat(): string;

    public abstract function photo(): string;

    public abstract function type(): string;

    public abstract function actions(): array;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        if (class_exists($this->type())) {
            if ($this->type() === Lion::class) {
                return 'Lion';
            }
            if ($this->type() === Crocodile::class) {
                return 'Crocodile';
            }
            if ($this->type() === Elephant::class) {
                return 'Elephant';
            }
        }

        return 'Undefined animal';
    }

    public function getCage(): ?Cage
    {
        return $this->cage;
    }

    public function setCage(?Cage $cage): self
    {
        $this->cage = $cage;

        return $this;
    }

    public function isExistAction(int $action): bool
    {
        return in_array($action, $this->actions());
    }

    public function runAction(int $action): string
    {
        if (isset(self::ACTIONS_METHODS[$action])) {
            $method = self::ACTIONS_METHODS[$action];
            if (method_exists($this, $method)) {
                return call_user_func([$this, $method]);
            }
        }
        throw new Exception('Action method not found');
    }
}
