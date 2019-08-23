<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class ContactController extends AbstractController
{
    

    /** 
     * @Route ("/contact")
    */
    public function contact(Request $request)
    {
        $contact = new Contact(); // Crée le contact vide

        $form = $this->createForm(ContactType::class, $contact); // Crée le formulaire avec l'objet à hydrater

        $form->handleRequest($request); // Traite la requête

        if ($form->isSubmitted() && $form->isValid()){
            // $contact->getEmail(); Permet de récupérer l'email saisi dans le formulaire
            // $contact->getName(); Permet de récupérer l'name saisi dans le formulaire
            // $contact->getMessage(); Permet de récupérer l'Message saisi dans le formulaire
            $this->addFlash('success',"Votre formulaire est bien envoyé :" .$contact->getEmail()); // Ajout du message Flash avec l'email vers lequel il a été envoyé
        }

        // La redirection évite de ré-exécuter le formulaire
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function index($name, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                    // templates/emails/registration.txt.twig
                    'emails/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);

        return $this->render('contact/contact.html.twig');
    }

  

  
}