<?php

namespace App\Entity\Animals;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;

/**
 * @ORM\Entity
 */
class Elephant extends Animal
{
    public function eat(): string
    {
        return 'I am eating grass';
    }

    public function wateringMyselfWithTrunk(): string
    {
        return "I am watering myself with a trunk";
    }

    public function photo(): string
    {
        return 'photos/elephant.jpeg';
    }

    public function type(): string
    {
        return Elephant::class;
    }

    public function actions(): array
    {
        return [self::ACTION_EAT, self::ACTION_FUNNY];
    }
}