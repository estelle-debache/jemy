<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Entity\Entreprise;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function dump;
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
        
dump($this->getUser());
        return $this->render('salarie/index.html.twig');
    }
    
    /**
     * 
     * @Route("/monprofil" )
     */
    public function monprofil()
    {
        return $this->render('salarie/monprofil.html.twig');
    }
    
    /**
     * 
     * @Route("/profiledit/{id}" )
     */
    public function ProfilEdit(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
         $salarie = $em->find(Salarie::class, $id);

        return $this->render('salarie/profiledit.html.twig');
    }
    
    /**
     * 
     * @Route("/mes-conges")
     */
    public function mesConges()
    {
        return $this->render('salarie/mes-conges.html.twig');
    }
    
    /**
     * 
     * @Route("/mes-fiches-de-paie")
     */
    public function mesFichesDePaie()
    {
        return $this->render('salarie/mes-fiches-de-paie.html.twig');
    }
    
    /**
     * 
     * @Route("/trombinoscope" )
     */
    public function trombinoscope()
    {
        
        return $this->render('salarie/trombinoscope.html.twig');
    }
    
    /**
     * 
     * @Route("/news")
     */
    public function news()
    {
        return $this->render('salarie/news.html.twig');
    }
    
    /**
     * 
     * @Route("/offres-emploi")
     */
    public function offresEmploi()
    {
        return $this->render('salarie/offres-emploi.html.twig');
    }
}
