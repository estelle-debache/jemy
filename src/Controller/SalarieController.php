<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use App\Entity\Salarie;
use App\Form\OffresemploiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    public function offresEmploi(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       
     
       $offresemploi= new OffreEmploi();
       $offresemploi->setEntreprise($this->getUser());
       $offresemploi->setService($this->getUser());
       
       
   
       $form = $this->createForm(OffresemploiType::class, $offresemploi);
       $form->handleRequest($request);
       if( $form->isSubmitted())
        {
            if($form->isValid())
            {
                
               
                
                
           

                $em->persist($offresemploi);
                $em->flush();
                return $this->redirectToRoute('app_salarie_index');
            }
        }
       
       return $this->render('salarie/offres-emploi.html.twig',
                 [
                     
                     'form'=>$form->createView()
                 ]);
        
    }
}
