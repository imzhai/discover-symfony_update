<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    // Générer des URLs
    /**
     * @Route("/urls")
     */
    public function genererUrls()
    {
        // La méthode generateUrl dans AbstractController permet de générer une URL à partir du nom d'une route
        $url = $this->generateUrl('hello');
        dump($url); // Affiche /hello
    }
    // Redirection
    /**
     * @Route("/redirect")
     */
    public function redirection()
    {
        // Redirection vers la page /hello
        return $this->redirectToRoute('hello');
    }

    // Afficher une 404
    /**
     * @Route("/notfound")
     */
    public function notfound()
    {
        // throw signifie "Lever une exception"
        throw $this->createNotFoundException();
    }

    /*
     * On va créer deux nouvelles routes :
     * /voir-session : Afficher le contenu de la clé 'name' dans la session
     *                 Renvoie "null" lors de la première visite sur le site
     * /mettre-en-session/{name} : Mettre en session (dans la clé 'name') la valeur passée dans l'URL
     */

    /**
     * @Route("/voir-session", name="show_session")
     * Ne pas oublier le "use Symfony\Component\HttpFoundation\Session\SessionInterface;"
     * Le paramètre $session nous permet de récupérer la session ($_SESSION)
     */
    public function showSession(SessionInterface $session)
    {
        // Récupérer le prénom en session
        $name = $session->get('name'); // Equivaut à $_SESSION['name']
        dump($name);
        return new Response('<body>Nom en session : '.$name.'</body>');
    }

    /**
     * @Route("/mettre-en-session/{name}", name="put_session")
     */
    public function putSession(SessionInterface $session, $name)
    {
        // On ajoute le nom de l'URL dans la session
        $session->set('name', $name);
        return new Response('<body>Mis en session : '.$name.'</body>');
    }
}
