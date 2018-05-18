<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * 
     * @Route("/liste-salaries")
     */
    public function listeSalaries()
    {
        return $this->render('admin/liste-salaries.html.twig');
    }
    
    /**
     * 
     * @Route("/ajout-salaries")
     */
    public function ajoutSalaries()
    {
        return $this->render('admin/ajout-salaries.html.twig');
    }
    
    /**
     * 
     * @Route("/les-conges")
     */
    public function lesConges() 
    {
        return $this->render('admin/les-conges.html.twig');
    }
}
