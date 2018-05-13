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
     * @Route("/" , name="salarie-tdb")
     */
    public function index()
    {
        return $this->render('salarie/index.html.twig');
    }
    
    /**
     * 
     * @Route("/mon-profil" , name="salarie-monprofil")
     */
    public function monProfil()
    {
        return $this->render('salarie/mon-profil.html.twig');
    }
}
