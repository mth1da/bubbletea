<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Repository\DrinkRepository;
use App\Repository\PoppingRepository;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DrinkController extends AbstractController
{
    #[Route('/drinks', name: 'app_drinks')]
    public function index(DrinkRepository $drinkRepository, Request $request): Response
    {
        $session = $request->getSession();
        /*$session->set('order', []);*/
        return $this->render('drinks/index.html.twig', [
            'drinks' => $drinkRepository->findBy(['is_on_menu' => true]),
        ]);
    }

    /*
    #[Route('/drinks/show/{id}', name: 'app_drinks_show')]
    public function show(int $id, PoppingRepository $poppingRepository, DrinkRepository $drinkRepository, SessionInterface $session): Response
    {
        return $this->render('drinks/show.html.twig', [
            'drink' => $drinkRepository->find($id),
            'poppings' => $poppingRepository->findAll()
        ]);
    }*/

    #[Route('/drinks/add/{id}', name: 'app_drinks_add')]
    public function add(int $id, SessionInterface $session, DrinkRepository $drinkRepository): Response
    {
        $drink = $drinkRepository->find($id);

        try{
            //on crée une session avec drinks
            if ($session->has('drinks')){
                $cart = $session->get('drinks');
                $cart[] = [
                    'drink' => $drink,
                    'poppings' => $drink->getDrinkPopping()->toArray(),
                ];
                $session->set('drinks', $cart);
            } else {
                $cart[] = [
                    'drink' => $drink,
                    'poppings' => $drink->getDrinkPopping()->toArray(),
                ];
                $session->set('drinks', $cart);
            }

            $this->addFlash('success', 'Votre boisson a bien été ajoutée au panier');
        } catch(Exception){
            $this->addFlash('danger', 'Un problème est survenu lors de l\'ajout au panier');
        }

        return $this->redirectToRoute('app_drinks');
    }
}
