<?php

namespace App\Controller;

use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(DrinkRepository $drinkRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'drinks' => $drinkRepository->findBy(['is_part_of_menu' => true]),
        ]);
    }

    #[Route('/admin/show/{id}', name: 'app_admin_show')]
    public function show(int $id, DrinkRepository $drinkRepository, EntityManagerInterface $entityManager): Response
    {
        $drink = $drinkRepository->find($id);
        $drink->setIsOnMenu(True);

        $entityManager->persist($drink);
        $entityManager->flush();

        $this->addFlash('success', 'Boisson ajoutée à la carte avec succès');

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/hide/{id}', name: 'app_admin_hide')]
    public function hide(int $id, DrinkRepository $drinkRepository, EntityManagerInterface $entityManager): Response
    {
        $drink = $drinkRepository->find($id);
        $drink->setIsOnMenu(False);

        $entityManager->persist($drink);
        $entityManager->flush();

        $this->addFlash('success', 'Boisson retirée de la carte avec succès');

        return $this->redirectToRoute('app_admin');
    }
}
