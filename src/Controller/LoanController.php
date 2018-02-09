<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class LoanController extends Controller
{
    /**
     * @Route("/add/product", name="add_product")
     */
    public function addProduct(ObjectManager $manager, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour accéder à cette page');
        
        $product = new Product();
        
        $form = $this->createForm(ProductType::class, $product)
            ->add('Envoyer', SubmitType::class);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            // Upload du fichier image
            // on récupère l'image depuis notre product
            $image = $product->getImage();
            // on doit mettre mettre les images dans un dossier (dossier uploads -> sous-dossier product)
            // php gère une chaine de caractères aléatoire en utilisant uniqid()
            $fileName = md5(uniqid()).'.'.$image->guessExtension();
            // move_uploaded_file (en procédural)
            $image->move('uploads/product', $fileName);
            $product->setImage($fileName);
            $product->setUser($this->getUser());
            
            // Enregistrement du produit
            $manager->persist($product);
            $manager->flush();
            //redirectionne vers le produit : ce qui vaut en php procédural à faire -> (location:my_products.html.twig)
             return $this->redirectToRoute('m_products');
        }
        return $this->render('add_product.html.twig', [
            
            'form' => $form->createView()
            
        ]);
        
    }
    /**
     * @Route("/product", name="my_products")
     */
    public function myProducts()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour accéder à cette page');
        return $this->render('my_products.html.twig'); 
    }        
    
}
