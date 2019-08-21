<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            ['name' => 'iPhone XS', 'slug' => 'iphone-xs', 'description' => 'Un iPhone de 2018','price' => '1199']

        ];
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
     * @Route ("/product/", name="product_list")
     * 
     * Liste des produits dans un tableau html
     */

    public function productList()
    { 
        return $this->render('product/productList.html.twig',[
            'products' =>$this->products,
          
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
}


