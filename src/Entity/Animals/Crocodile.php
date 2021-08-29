<?php

namespace App\Entity\Animals;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;

/**
 * @ORM\Entity
 */
class Crocodile extends Animal implements Predators
{
    public function eat(): string
    {
        return 'I am eating fish';
    }

    public function swimming(): string
    {
        if ($this->getCage()) {
            return 'I can`t because i am in cage. Free me';
        }
        return "I am swimming";
    }

    public function growl(): string
    {
        return 'RRR...';
    }

    public function photo(): string
    {
        return 'photos/crocodile.jpeg';
    }

    public function type(): string
    {
        return Crocodile::class;
    }

    public function actions(): array
    {
        return [self::ACTION_EAT, self::ACTION_GROWL, self::ACTION_SWIMMING];
    }
}