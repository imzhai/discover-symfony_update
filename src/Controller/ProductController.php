<?php

namespace App\Controller;

use App\Entity\Product;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductController extends AbstractController
{
    // /**
    //  * @Route("/product/{page}", name="product_list", requirements={"page"="\d+"})
    //  */
    // public function list($page)
    // {
    //     return new Response('<body>Liste des produits page '.$page.'</body>');
    // }

    // /**
    //  * Si on se rend sur /product/toto ou /product/titi
    //  * Un slug, c'est transformer "iPhone X" en "iphone-x"
    //  *
    //  * @Route("/product/{slug}", name="product_show")
    //  */
    // public function show($slug, LoggerInterface $logger)
    // {
    //     dump($slug);
    //     // Je fais un log avec le service Monolog de Symfony
    //     $logger->info('Visite du produit '.$slug);

    //     return $this->render('product/show.html.twig');
    // }


    public $products = [];

    public function __construct()
    {
        // On initialise un tableau avec des produits
        // L'attribut $products est accessible sur toutes les routes
        $this->products = [

            ['name' => 'iPhone X', 'slug' => 'iphone-x', 'description' => 'Un iPhone de 2017','price' => '999'],
            ['name' =>  'iPhone XR', 'slug' => 'iphone-xr', 'description' => 'Un iPhone de 2018','price' => '1099'],
            ['name' => 'iPhone XS', 'slug' => 'iphone-xs', 'description' => 'Un iPhone de 2018','price' => '1199'],
            ['name' => 'iPhone XW', 'slug' => 'iphone-xw', 'description' => 'Un iPhone de 2018','price' => '1199'],
            ['name' => 'iPhone XX', 'slug' => 'iphone-xx', 'description' => 'Un iPhone de 2018','price' => '1199'],
            ['name' => 'iPhone XY', 'slug' => 'iphone-xy', 'description' => 'Un iPhone de 2018','price' => '1199']


        ];
    }

    /** 
    * @Route("/product/create")
    */

    public function create(Request $request)
    {
        // On crée un produit "vierge
        $product = new Product();
        dump($product);
        // Créer un formulaire dans le contrôleur
        $form = $this->createFormBuilder($product)
            ->add('name')
            ->add('description', TextareaType::class )
            ->getForm();

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() renvoie les données soumises
            dump($form->getData());
            dump($product);
        }



        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/product/random", name="product_random")
     * 
     * recupère un produit aléatoire du tableau produits
     */

     public function random()
     {
      
        $key = array_rand($this->products);
        $product = $this->products[$key];
        dump($product);
        return $this->render('product/random.html.twig',[
            'products' => $this->products[$key],
            'product' => $product,
        ]);
     }

     
     /**
     * @Route ("/product/{page}", requirements={"page" = "\d+"}, name="product_list")
     * 
     * Liste des produits dans un tableau html // Réaliser pagination 
     */

    public function productList($page = 1)
    { 
        $products = $this->products;
        // array_slice( début, nombre d'elements pris en compte)
        $products = array_slice($products, ($page - 1) * 2, 2);
        // Calculer le nombre de page maximal. On compte les occurrences du tableau grâce a count() puis on arrondit
        // Ceil permet d'arrondir au supérieur
        $maxPages = ceil(count($this->products) / 2);

        // Si la page courante est supérieure au nombre maximum de pages
        // On renvoit un 404
        if ($page > $maxPages)
        {
            throw $this->createNotFoundException();
        }

        return $this->render('product/productList.html.twig',[
            'products' => $products,
            'current_page' => $page,
            'max_pages' => $maxPages
        ]);
    }

    
    /**
     * @Route ("/product/{slug}", name="product_slug")
     * 
     * renvoie un produit avec ses informations au format HTML, renvoie une 404 si le produit n'existe pas.
     */

    public function product($slug)
    { 
        foreach($this->products as $product) 
        {
            // Si le slug du produit correspond à celui de l'URL
            if ($product['slug'] === $slug)
            {
                // Si un produit existe avec le slug, on retourne le template et on arrête le code
                return $this->render('product/random.html.twig',[
                    'product' => $product,
                    ]);
            } 
        }


        throw $this->createNotFoundException('Ce produit n\'existe pas');
    }

    /** 
     * @Route("/product.json")
    */
    public function api()
    {
        // On renvoie le tableau des produits sous forme de JSON
        return $this->json($this->products);
    }


    /** 
     * @Route("/product/order/{slug}")
    */
    public function order($slug)
    {
        // $alphabet = ['A', 'B', 'C'];
        // //$newAlphabet = ['A']
        // $newAlphabet = array_filter($alphabet, function($lettre) {return $lettre === 'A';});

        //Chercher le produit concerné dans notre tableau
        // Le terme "use" du callback permet d'utiliser une variable définie en dehors de celui-ci
        $product = array_filter($this->products, function ($product) use ($slug)
        {
            // cette fonction est appelée sur chaque élément du tableau.
            // On renvoie truc si on veit garder l'élément dans le filtre qu'on applique
            return $product['slug'] === $slug;
        });
        
        // Réinitialise les index du tableau filtré
        $product = array_values($product);
        // On ne prends qu'un seul produit
        $product = $product[0];



        $this->addFlash('success',"Nous avons bien pris en compte votre commande de l' ".$product['name']);

        // APrès la commande, on redirige vers la liste des produits.
        return $this->redirectToRoute('product_list');
    }

}


