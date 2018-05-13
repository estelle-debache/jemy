<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    /**
     * @Route("/salarie")
     */
class SalarieController extends Controller
{
    /**
     * 
     * @Route("/")
     */
    public function index()
    {
        return $this->render('salarie/inscription.html.twig');
    }
    public function inscription()
    {
        
        
        return $this->render('salarie/inscription.html.twig');
    }
    
    
    
}
