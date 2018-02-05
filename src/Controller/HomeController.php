<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller {
    // Permet de lui dire le chemain jusqu'à home (localhost:8000/home)
    
    /** 
     * @Route("/")
     * @Route("/home")     
     */
    public function home() {// permet d'afficher la page d'accueil, c'est une action qui s'occupe seule de l'index.php
        return $this->render('home.html.twig');
    }
}
