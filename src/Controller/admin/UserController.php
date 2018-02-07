<?php

namespace App\Controller\admin;

use App\Entity\User; // avant pour UserRepository : use App\Controller\admin;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/admin/user", name="list_user")
     */
    public function getList(UserRepository $userRepo) // On demande d'injecter l'$userRepo dans le fichier UserRepository.php
    { // C'est la classe = \App\Repository\UserRepository et $userRepo est un objet (permet de récuperer tous les utilisateurs)
        //$userRepo = new \App\Repository\UserRepository(); idem ce qu'il y a dans la parenthèse
        // notre repository est "injecté" en paramètre de l'action (la méthode) de notre contrôleur.
        //$userRepo contient donc une instance (un objet) prêt à l'emploi de class UserRepository.
        // Cette objet nous sert à récupérer notre list d'utilisateur.
        $users = $userRepo->findAll();
        return $this->render('admin/list_user.html.twig', [
            'users' => $users
        ]); // render sert à faire apparaître la vue
    }
    
    /**
     * @Route("/admin/user/{id}", name="user_details")
     */
    public function details(User $user) {
        // public function details(User $user) -> app/entity/user (chemin en faisant ctrl+shift+i)
        //  public function details(UserRepository $userRepo, $id
        //$user = $userRepo->find($id); quand on avait mis UserRepository dans la fonction details()
        // tableau associatif []
        return $this->render('admin/details_user.html.twig', [
            'user' => $user
        ]);
        
    }       
            
                      
}
