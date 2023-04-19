<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TotalService
{

    public function calculateTotal(SessionInterface $session): int
    {
        $totalPrice = 0;
        $cart=$session->get('drinks');

        //($cart[0]['drink']);

        if($cart){
            foreach ($cart as $bubbletea){
               $totalPrice += $bubbletea['drink']->getPrice();
            }
        }

        return $totalPrice;
    }
}