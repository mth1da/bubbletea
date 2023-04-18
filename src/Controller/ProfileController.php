<?php

namespace App\Controller;

use App\Form\EditProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
       #[Route('/profile', name: 'app_profile')]
    public function edit(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        //on récupère le user connecté
        $user = $this->getUser();

        //on crée le formulaire
        $editForm = $this->createForm(EditProfileFormType::class, $user );

        //on traite la requête du form
        $editForm->handleRequest($request);

        //on vérifie que le formulaire est soumis & valide
        if($editForm->isSubmitted() && $editForm->isValid()){
            //on encode le password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $editForm->get('password')->getData()
                )
            );
            $user->setUpdatedAt(New \DateTimeImmutable());
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil a bien été mis à jour');

            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/edit.html.twig', [
            'editForm' => $editForm->createView(),
        ]);
    }
}
