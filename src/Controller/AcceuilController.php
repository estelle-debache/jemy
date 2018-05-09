<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



/**
 * @Route("/acceuil")
 */
class AcceuilController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('acceuil/index.html.twig');
    }
    
    /**
     * 
     * @Route("/inscription")
     */
    public function inscription()
    {
        return $this->render('acceuil/inscription.html.twig');
    }
    
    /**
     * 
     * @Route("/connexion")
     */
    public function connexion ()
    {
        return $this->render("acceuil/connexion.html.twig");
    }
    
    
    
    
}
