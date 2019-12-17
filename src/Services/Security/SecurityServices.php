<?php


namespace App\Services\Security;


use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;


class SecurityServices extends AbstractController
{
    private $manager;

    private  $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    public function formCreate(Request $request) {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $this->validationForm($user);
            $form = true ;
            return $form;
        }
            return $form;
    }

    public function validationForm(User $user) {
        $pass_hash = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($pass_hash);
        $user->setRoles(['ROLES_USER']);
        $this->manager->persist($user);
        $this->manager->flush();
    }

}