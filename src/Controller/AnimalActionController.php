<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class AnimalActionController extends AbstractController
{
    private $animalRepository;

    public function __construct(AnimalRepository $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    /**
     * @Route("/animal/action/{animalId}/{action}", name="actions")
     */
    public function executeAction(int $animalId, int $action): JsonResponse
    {
        $animal = $this->animalRepository->find($animalId);

        if (!$animal) {
            return $this->json(['message' => 'Animal not found'], Response::HTTP_BAD_REQUEST);
        }

        if (!$animal->isExistAction($action)) {
            return $this->json(['message' => 'Action not found'], Response::HTTP_BAD_REQUEST);
        }

        try {
            return $this->json([
                'message' => $animal->runAction($action)
            ]);
        } catch (Throwable $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
