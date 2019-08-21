<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{page}", name="product_list", requirements={"page"="\d+"})
     */
    public function list($page)
    {
        return new Response('<body>Liste des produits page '.$page.'</body>');
    }

    /**
     * Si on se rend sur /product/toto ou /product/titi
     * Un slug, c'est transformer "iPhone X" en "iphone-x"
     *
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug, LoggerInterface $logger)
    {
        dump($slug);
        // Je fais un log avec le service Monolog de Symfony
        $logger->info('Visite du produit '.$slug);

        return $this->render('product/show.html.twig');
    }
}
