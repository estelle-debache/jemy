<?php

namespace App\Controller;
use App\Entity\Salarie;
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
     * @Route("/monprofil" )
     */
    public function monprofil()
    {
        return $this->render('salarie/monprofil.html.twig');
    }
    
    /**
     * 
     * @Route("/mon-profil-edit" )
     */
    public function monProfilEdit()
    {
        return $this->render('salarie/mon-profil-edit.html.twig');
    }
    
    /**
     * 
     * @Route("/mes-conges" , name="salarie-mesconges")
     */
    public function mesConges()
    {
        return $this->render('salarie/mes-conges.html.twig');
    }
    
    /**
     * 
     * @Route("/mes-fiches-de-paie" , name="salarie-fichesdepaie")
     */
    public function mesFichesDePaie()
    {
        return $this->render('salarie/mes-fiches-de-paie.html.twig');
    }
    
    /**
     * 
     * @Route("/trombinoscope" , name="salarie-trombinoscope")
     */
    public function trombinoscope()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Salarie::class);
        $salaries = $repository->findAll();
        
        
        return $this->render('salarie/trombinoscope.html.twig',
                [
                    'salaries' => $salaries
                ]);
    }
    
    /**
     * 
     * @Route("/news" , name="salarie-news")
     */
    public function news()
    {
        return $this->render('salarie/news.html.twig');
    }
}
