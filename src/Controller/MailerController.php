<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/admin/forgotten_password", name="forgotten_password")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        if(isset($_POST['submit'])){
        $mail=$_POST['_username'];
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(array('email'=>$mail));
        $email = (new Email())
            ->from('symfonyACDC@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Information de ". $user->getUsername())
            ->text('')
            ->html('<p>votre mot de passe est '. $user->getPassword(). '</p>');

        /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
        $sentEmail = $mailer->send($email);
        // $messageId = $sentEmail->getMessageId();
        }
        return $this->render('admin/forgotten_password.html.twig');
    }
}

?>