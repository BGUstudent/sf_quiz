<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Questions;
use App\Form\RegistrationType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;


class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/manage", name="manage")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('admin/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/login", name="login")
     */
    public function login(){
        
        return $this->render('admin/login.html.twig');
    }

    /**
     * @Route("/admin/logout", name="logout")
     */
    public function logout(){}

}