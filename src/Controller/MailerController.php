<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Repository\AlbumRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailerController extends AbstractController
{
    
    /**
    * @Route("/contact", name="contact", methods={"POST", "GET"})
    */
    public function contact(Request $request, MailerInterface $mailer, AlbumRepository $albumRepo ){

        $albums = $albumRepo->findAll();
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
                $this -> addFlash('danger', 'A problem occured. Please try later.');
                return $this->redirectToRoute("contact");
            }
        }
        
        return $this->render('home/contact.html.twig', [
            'form'       => $form->createView(),
            'albums'     => $albums,
            'controller' => 'contact',
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
                    'sender'  => $data['Email'],
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
        }else{
            return false;
        }
    }

//AJAX under-construction route
     /**
     * @Route("/contact/post", name="post_message", methods={"POST"})
     */
    /*
    public function post(Request $request, MailerInterface $mailer)
    {
            $form = $this->createForm(ContactType::class);
            $form->submit($request->request->get('contact'));

            try{
                
                $data = $form -> getData();
                $this -> sendEmail($data, $mailer);
                $message =  $this -> addFlash('success', 'Your message has been sent successfully');
  
                return new JsonResponse([
                    'success' => true, 
                    'message' =>  $message->renderView('includes/partials/_flash_messages.html.twig')]);
            }catch(Exception $e){
                $message = $e->getMessage();
                return new JsonResponse([
                    'success' => false,
                    'message' => $message->renderView('includes/partials/_flash_messages.html.twig')]);
                    ]);
            }
    }
 */   
   
}
