<?php

namespace App\Controller;

use App\Service\AccountMailer;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function dashboard(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        return $this->render('pages/account/dashboard.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/account/edit', name: 'app_account_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        AccountMailer $accountMailer
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPlainPassword()));
                $user->setPlainPassword(null);
            }

            $user->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();

            $accountMailer->sendProfileUpdatedEmail($user);

            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('app_account');
        }

        return $this->render('pages/account/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
