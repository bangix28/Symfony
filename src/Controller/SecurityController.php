<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Security\SecurityServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends AbstractController
{
    /**
    *@Route("/inscription", name="security_registration")
     *
     */
    public function registration(SecurityServices $securityServices, Request $request)
    {

        $form = $securityServices->formCreate($request);
        if ($form === true) {
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()  {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}
}
