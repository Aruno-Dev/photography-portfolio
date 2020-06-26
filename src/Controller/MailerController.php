<?php

namespace App\Controller;

use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mime\Address;
use App\Form\ContactType;
use App\Repository\AlbumRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Exception;


class MailerController extends AbstractController
{
    
    /**
    * @Route("/contact", name="contact", methods={"POST", "GET"})
    */
    public function contact(AlbumRepository $albumRepo ){

        $albums = $albumRepo->findAll();
        $form   = $this->createForm(ContactType::class);
        return $this->render('home/contact.html.twig', [
            'form'       => $form->createView(),
            'albums'     => $albums,
            'controller' => 'contact',
        ]);
    }

    private function sendEmail($data, MailerInterface $mailer)
    {
        $email = (new TemplatedEmail())
                ->from($data['Email'])
                ->to(new Address('arnaud.terret@gmail.com'))
                ->replyTo($data['Email'])
                ->subject($data['Subject'])
                ->htmlTemplate('/home/templated_emails/contact_email.html.twig')
                ->context([
                    'sender'  => $data['Email'],
                    'subject' => $data['Subject'],
                    'message' => $data['Message']
                ])
                ;
        $mailer->send($email);
    }

     /**
     * @Route("/contact/post", name="post_message", methods={"POST"})
     */
    public function post(Request $request, MailerInterface $mailer)
    {
        if($request->request->get('contact')){
            $form = $this->createForm(ContactType::class);
            $form->submit($request->request->get('contact'));
            $data = $form -> getData();
        }else{
            $form = $this->createForm(CommentType::class);
            $form->submit($request->request->get('comment'));
            $data = [
                'Email'    =>$form->getData()->getEmail(),
                'Subject'  =>'You have a new comment',
                'Message'  =>$form->getData()->getContent()
            ];
        }
            try{
                $this -> sendEmail($data, $mailer);
                return new JsonResponse([
                    'success' => true,
                    'data'    => $data
                    ]);
            }catch(Exception $e){
                return new JsonResponse([
                    'success' => false,
                    'message' => $e->getMessage()
                    ]);
            }
    }
}
