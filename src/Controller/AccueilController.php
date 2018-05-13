<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Salarie;
use App\Form\EntrepriseType;
use App\Form\SalarieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function dump;

/**
 * @Route("/accueil")
 */
class AccueilController extends Controller
{
    /**
     * @Route("/" , name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig');
    }
    
    /**
     * 
     * @Route("/inscription" , name="inscription")
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
            $em->flush();
        
            dump($entreprise->getId());
            
            $idEntreprise = $entreprise->getId();
            
            $session = $request->getSession();
        
            $session->set('id', $idEntreprise);
            dump($session->get('id'));
            
            $this->addFlash('success', " felicitation Votre Entreprise a ete créé");
            return $this->redirectToRoute('inscription-admin');
         
        }
                
        
        return $this->render('accueil/inscription.html.twig',
                 [
                     //passage du formulaire a la vue
                     'form'=>$form->createView()
                 ]);
        
    }
    
    /**
     * 
     * @Route("/inscription-admin" , name="inscription-admin")
     */
    public function inscriptionAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $session = $request->getSession();
        $idEntreprise = $session->get('id');
        
        $salarie = new Salarie();
        
        $form = $this->createForm(SalarieType::class, $salarie);
        // le formulaire analyse la requete HTTP
        $form->handleRequest($request);
        
        if( $form->isSubmitted())
        {
            $password = $passwordEncoder->encodePassword($salarie, $salarie->getplainPassword());
            $salarie
                ->setPassword($password)
                ->setEntreprise_id($idEntreprise)
                ->setRole('ROLE_ADMIN')
                ->setService('RH');
        $em->persist($salarie);
        $em->flush();
        return $this->redirectToRoute('app_salarie_monProfil');
        }
        return $this->render('accueil/inscription-admin.html.twig',
                 [
                     //passage du formulaire a la vue
                     'form'=>$form->createView()
                 ]);
        
    }

    /**
     * 
     * @Route("/connexion" , name="connexion")
     */
    public function connexion ()
    {
        return $this->render("accueil/connexion.html.twig");
    }
       
}
