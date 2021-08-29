<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Cage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class CageActionController extends AbstractController
{

    /**
     * @Route("/cage/clear/{id}", name="cage_action_clear")
     */
    public function clearCage(Cage $cage): JsonResponse
    {
        if ($cage->getAnimals()->count()) {
            return $this->json([
                'message' => 'You can`t clear cage because in cage animal exist'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Cage cleared']);
    }

    /**
     * @Route("/cage/free/{id}", name="cage_action_free")
     */
    public function freeAnimal(Animal $animal, EntityManagerInterface $entityManager): JsonResponse
    {
        $animal->setCage(null);
        $entityManager->flush();

        return $this->json(['message' => 'Animal free']);
    }

    /**
     * @Route("/cage/add/{cageId}/{animalId}", name="cage_action_add")
     */
    public function addAnimal(int $cageId, int $animalId, EntityManagerInterface $entityManager): JsonResponse
    {
        $cage = $entityManager->getRepository(Cage::class)->find($cageId);
        if (!$cage) {
            return $this->json(['message' => 'Cage not found'], Response::HTTP_BAD_REQUEST);
        }

        $animal = $entityManager->getRepository(Animal::class)->find($animalId);
        if (!$animal) {
            return $this->json(['message' => 'Animal not found'], Response::HTTP_BAD_REQUEST);
        }
        try {
            $cage->addAnimal($animal);
            $entityManager->flush();
            return $this->json(['message' => 'Animal add to cage']);
        } catch (Throwable $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
