<?php

namespace App\Controller;

use App\Repository\DrinkRepository;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DrinkController extends AbstractController
{
    #[Route('/drinks', name: 'app_drinks')]
    public function index(DrinkRepository $drinkRepository): Response
    {
        return $this->render('drinks/index.html.twig', [
            'drinks' => $drinkRepository->findBy(['is_on_menu' => true]),
        ]);
    }

    #[Route('/drinks/add/{id}', name: 'app_drinks_add')]
    public function add(int $id, SessionInterface $session, DrinkRepository $drinkRepository): Response
    {
        $drink = $drinkRepository->find($id);

        //on crée une session avec drinks (correspond au panier)
        //consititué d'un array avec, pour chaque entrée,
        //les boissons sous forme d'entity 'drink' et leurs poppings associés sous formes d'array 'poppings'
        try{
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
