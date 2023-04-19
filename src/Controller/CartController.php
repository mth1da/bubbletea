<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Entity\Order;
use App\Repository\PoppingRepository;
use App\Service\TotalService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    public function __construct(TotalService $service)
    {
        $this->service = $service;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, PoppingRepository $poppingRepository): Response
    {
        $cart = $session->get('drinks');
        //dd($cart);
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'poppings' => $poppingRepository->findAll(),
            'total' => $this->service->calculateTotal($session)
        ]);
    }

    #[Route('/cart/add/sugar/{key}', name: 'app_cart_add_sugar')]
    public function addSugarQuantity(int $key, SessionInterface $session, PoppingRepository $poppingRepository): Response
    {
        //on cherche la boisson grace au key de la session
        $bubbletea = $session->get('drinks')[$key]['drink'];

        $currentSugarQuantity = $bubbletea->getSugarQuantity();

        if ($currentSugarQuantity >= 10){
            $this->addFlash('danger', 'Trop de sucre est mauvais pour la santé');
        } else{
            //on ajoute 1 sucre à la quantité de sucre existante
            $bubbletea->setSugarQuantity($currentSugarQuantity + 1);
            $this->addFlash('success', 'Du sucre a bien été ajouté à votre boisson');
        }

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/discard/sugar/{key}', name: 'app_cart_discard_sugar')]
    public function discardSugarQuantity(int $key, SessionInterface $session, PoppingRepository $poppingRepository): Response
    {
        //on cherche la boisson grace au key de la session
        $bubletea= $session->get('drinks')[$key]['drink'];

        $currentSugarQuantity = $bubletea->getSugarQuantity();

        if ($currentSugarQuantity <= 0) {
            $this->addFlash('danger', 'Il n\'y a plus de sucre dans votre boisson' );
        } else {
            //on enlève 1 sucre à la quantité de sucre existante
            $bubletea->setSugarQuantity($bubletea->getSugarQuantity() - 1);
            $this->addFlash('success', 'Du sucre a bien été supprimé de votre boisson');
        }

        return $this->redirectToRoute('app_cart');

    }

    #[Route('/cart/add/{key}/popping/{id}', name: 'app_cart_add_popping')]
    public function addPopping(int $key, int $id, SessionInterface $session, PoppingRepository $poppingRepository): Response
    {
        //on récupère le panier
        $cart = $session->get('drinks');

        //on cherche la boisson grace au key de la session
        $bubbletea = $cart[$key];

        //on cherchhe les poppings associés
        $poppings = $bubbletea['poppings'];

        try{
            //on ajoute le popping sélectionné aux poppings déjà présents
            $poppings[] = $poppingRepository->find($id);

            //on update la boisson avec le nouveau popping
            $bubbletea['poppings'] = $poppings;

            //on update le panier avec la boisson maj
            $cart[$key] = $bubbletea;

            //on update la session
            $session->set('drinks', $cart);

            $this->addFlash('success', 'Popping ajouté avec succès');
        } catch(Exception){
            $this->addFlash('success', 'Un problème est survenu');
        }

        return $this->redirectToRoute('app_cart');

    }

    #[Route('/cart/discard/{key}/popping/{id}', name: 'app_cart_discard_popping')]
    public function discardPopping(int $key, int $id, SessionInterface $session, PoppingRepository $poppingRepository): Response
    {
        //on récupère le panier
        $cart = $session->get('drinks');

        //on cherche la boisson grace au key de la session
        $bubbletea = $cart[$key];

        //on cherche les poppings associés
        $poppings = $bubbletea['poppings'];

        try {
            //on supprime le popping sélectionné
            foreach ($poppings as $index => $popping) {
                if ($popping->getId() === $id) {
                    unset($poppings[$index]);
                    break;
                }
            }

            //on update la boisson sans le popping
            $bubbletea['poppings'] = array_values($poppings);

            //on update le panier avec la boisson maj
            $cart[$key] = $bubbletea;

            //on update la session
            $session->set('drinks', $cart);

            $this->addFlash('success', 'Popping retiré avec succès');

        } catch(Exception){
            $this->addFlash('success', 'Un problème est survenu');
        }

        return $this->redirectToRoute('app_cart');

    }

    #[Route('/cart/validate', name: 'app_cart_validate')]
    public function validate(SessionInterface $session, EntityManagerInterface $entityManager, PoppingRepository $poppingRepository): Response
    {
        //on récupère le user connecté
        $user = $this->getUser();

        //on récupère les boissons de la session
        $cart = $session->get('drinks');

        //on calcule le total
        $total = $this->service->calculateTotal($session);

        try{
            //on crée une nouvelle commande
            $order = new Order();

            foreach ($cart as $key => $bubbletea){

                //on crée une nouvelle boisson
                $drink = new Drink();
                $drink->setName($session->get('drinks')[$key]['drink']->getName());
                $drink->setFlavour($session->get('drinks')[$key]['drink']->getFlavour());
                $drink->setPrice($session->get('drinks')[$key]['drink']->getPrice());
                $drink->setSugarQuantity($session->get('drinks')[$key]['drink']->getSugarQuantity());
                $drink->setIsOnMenu(False);

                //on ajoute les poppings à la boisson
                foreach($bubbletea['poppings'] as $popping){
                    $drink->addDrinkPopping($poppingRepository->find($popping->getId()));
                }

                $entityManager->persist($drink);
                $entityManager->flush();

                //on ajoute la boisson à la commande
                $order->addOrderDrink($drink);
            }

            $order->setOrderUser($user);
            $order->setTotal($total);

            $entityManager->persist($order);
            $entityManager->flush();

            $session->remove('drinks');

            $this->addFlash('success', 'Commande validée avec succès');

        } catch (ORMException $e) {
            $this->addFlash('danger', 'Un problème est survenu');
        }

        return $this->redirectToRoute('app_cart');

    }
}
