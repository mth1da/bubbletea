<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('homepage/index.html.twig', [
            'orders' => $orderRepository->findby(['order_user' => $this->getUser()]),
        ]);
    }
}
