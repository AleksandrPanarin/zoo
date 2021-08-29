<?php

namespace App\Entity\Animals;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;

/**
 * @ORM\Entity
 */
class Lion extends Animal implements Predators
{
    public function eat(): string
    {
        return 'I am eating meat';
    }

    public function growl(): string
    {
        return 'RRR...';
    }

    public function photo(): string
    {
        return 'photos/lion.jpeg';
    }

    public function type(): string
    {
        return Lion::class;
    }

    public function actions(): array
    {
        return [self::ACTION_EAT, self::ACTION_GROWL];
    }
}