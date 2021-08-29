<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Repository\CageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(CageRepository $cageRepository, AnimalRepository $animalRepository): Response
    {
        $cages = $cageRepository->findAll();
        $freeAnimals = $animalRepository->findBy([
            'cage' => null
        ]);

        return $this->render('index/index.html.twig', [
            'cages' => $cages,
            'freeAnimals' => $freeAnimals,
            'actionClasses' => Animal::ACTIONS_CLASSES,
            'actionNames' => Animal::ACTIONS_NAMES,
        ]);
    }
}
