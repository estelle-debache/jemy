<?php

namespace App\Controller;
use App\Entity\Salarie;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin-tdb")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * 
     * @Route("/liste-salaries" , name="admin-liste-salaries")
     */
    public function listeSalaries()
    {
      
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Salarie::class);
        $salaries = $repository->findAll();
        
        
        return $this->render('admin/liste-salaries.html.twig',
                [
                    'salaries' => $salaries
                ]);
    }
    
    /**
     * 
     * @Route("/ajout-salaries" , name="admin-ajout-salaries")
     */
    public function ajoutSalaries()
    {
        return $this->render('admin/ajout-salaries.html.twig');
    }
}
