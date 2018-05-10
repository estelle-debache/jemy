<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route("/accueil")
 */
class AccueilController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig');
    }
    
    /**
     * 
     * @Route("/inscription")
     */
    public function inscription()
    {
        return $this->render('accueil/inscription.html.twig');
    }
    
    /**
     * 
     * @Route("/connexion")
     */
    public function connexion ()
    {
        return $this->render("accueil/connexion.html.twig");
    }
    
    
    
    
}
