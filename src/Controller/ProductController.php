<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/creer", name="product_create")
     */
    public function create()
    {
        $form = $this->createForm($type);
        return $this->render('product/create.html.twig',array(
            
        ));
        
    }
}