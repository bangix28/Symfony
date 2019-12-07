<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;




class SecurityController extends AbstractController
{
    /**
    *@Route("/security", name="security_registration")
     *
     */
    public function registration()
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
