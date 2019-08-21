<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    // On doit pouvoir :
    // Aller sur /hello/pierre => Hello Pierre
    // Aller sur /hello/juliette => Hello Juliette
    // Le prénom dans l'URL doit être dynamique et le contrôleur doit se charger d'ajouter la première lettre du prénom en majuscule et ensuite il doit passer la variable à la vue Twig.
    // BONUS : Si on va sur /hello, on doit afficher Hello tout le monde. Le nom saisi dans l'URL devra faire entre 3 et 8 caractères et sera composé uniquement de majuscule.

    /**
     * @Route("/hello/{prenom}", requirements={"prenom"="[A-Z]{3,8}"})
     */
    public function bonjour($prenom = 'tout le monde')
    {
        $prenom = ucfirst($prenom);

        return $this->render('welcome/bonjour.html.twig', [
            'prenom' => $prenom,
        ]);
    }

    /**
     * @Route("/hello", name="hello")
     */
    public function hello(Request $request)
    {
        $name = 'Matthieu';

        // $request->get('a') équivaut à $_GET['a']
        dump($request);

        // On fait un rendu de la vue Twig qui est située
        // dans le dossier templates/
        // Le controleur passe la variable name à la vue grâce au second paramètre de render qui est un tableau
        return $this->render('welcome/hello.html.twig', [
            'name' => $name,
        ]);
    }
}
