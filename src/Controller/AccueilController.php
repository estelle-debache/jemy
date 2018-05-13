<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function dump;

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
    public function inscription(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entreprise = new Entreprise();

        //creation d'un formulaire relié a la categorie
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        // le formulaire analyse la requete HTTP
        $form->handleRequest($request);
        
        //SI LE FORMULAIRE A ETE ENVOYE 
        if( $form->isSubmitted())
        {

                
                            // LES ATTRIBUT DE L'OBJETS CATEGORY ONT ETE SETTE A PARTIR DES CHAMPS DE FORMULAIRE 
            
            
 
            
            // RESTE PLKUS QUA LES METTRE EN BASE DE DONNéES 
            $em->persist($entreprise);
            $pouet=$em->flush();
        
            dump($entreprise->getId());
            
            $idEntreprise = $entreprise->getId();
            
            $session = $request->getSession();
        
            $session->set('id', $idEntreprise);
            dump($session->get('id'));
            
            $this->addFlash('success', " felicitation Votre Entreprise a ete créé");
            return $this->redirectToRoute('app_salarie_inscription');
         
        }
                
        
        return $this->render('accueil/inscription.html.twig',
                 [
                     //passage du formulaire a la vue
                     'form'=>$form->createView()
                 ]);
        
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
