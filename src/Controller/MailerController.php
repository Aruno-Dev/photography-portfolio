<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Mailer;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MailerController extends AbstractController
{
    
    /**
    * @Route("/contact", name="contact", methods={"POST", "GET"})
    */
    public function contact(Request $request, MailerInterface $mailer ){

        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                
            $data = $form -> getData();
            
            if($this -> sendEmail($data, $mailer))
            {
                $this -> addFlash('success', 'Your message has been sent successfully');
                return $this->redirectToRoute("contact");
            }
            else
            {
                $this -> addFlash('danger', 'A probem occured. Please try later.');
            }
        }
        
        return $this->render('home/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
    public function sendEmail($data, MailerInterface $mailer)
    {
        
        $email = (new TemplatedEmail())
                ->from($data['Email'])
                ->to(new Address('arnaud.terret@gmail.com'))
                ->replyTo($data['Email'])
                //->priority(Email::PRIORITY_HIGH)
                ->subject($data['Subject'])
                //->text($data['Message']);
                ->htmlTemplate('/home/emails/contact_email.html.twig')
                ->context([
                    'sender' => $data['Email'],
                    'subject' => $data['Subject'],
                    'message' => $data['Message']
                ])
                ;

            $mailer->send($email);

                $this->addFlash('success', 'email sent successfully !');
                

                return $this->redirectToRoute('contact');
    
        if($mailer -> send($email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
}
