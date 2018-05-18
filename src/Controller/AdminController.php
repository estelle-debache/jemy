<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Salarie;
use App\Form\ActualiteType;
use App\Form\SalarieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", )
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * 
     * @Route("/liste-salaries/{id}" )
     */
    public function listeSalaries()
    {
      
       
        
        return $this->render('admin/liste-salaries.html.twig', [
            'salaries' => 'salaries',
        ]);
    }
    
   
    
     /**
     * 
     * @Route("/ajout-salaries")
     */
    public function ajoutSalaries(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $salarie = new Salarie();
         
        $form = $this->createForm(SalarieType::class, $salarie);
        
        
        $form->handleRequest($request);
        
        // recupere un objet entreprise ayant l'id enregistre en session lors de la creation de l'entreprise 
        $entreprise = $this->getUser()->getEntreprise();
        
        // recupere un objet service ayant l'id enregistre en session lors de la creation de l'objet entreprise
        $service = $this->getUser()->getService();
        if( $form->isSubmitted())
        {
            if($form->isValid())
            {
                // recuperer le nom du fichier en bdd
                $photo = $salarie->getPhoto();
                $cni = $salarie->getCarteIdentite();
                $cdt = $salarie->getContratTravail();
                
                // modifier le nom obtenue lors de la precedente action
                $photoname= $salarie->getNumSs().'.'.$photo->guessExtension();
                $cniname=$salarie->getNumSs().'.'.$photo->guessExtension();
                $cdtname= $salarie->getNumSs().'.'.$photo->guessExtension();
                
                
                //deplacement des fichiers vers les dossiers dans images 
                
                $photo->move($this->getParameter('photo_dir'),$photoname);
                $cni->move($this->getParameter('cni_dir'),$cniname);
                $cdt->move($this->getParameter('photo_dir'),$cdtname);
                
                // encodage du password
                $password = $passwordEncoder->encodePassword($salarie, $salarie->getplainPassword());
                $salarie
                    ->setPassword($password)
                    ->setEntreprise($entreprise)
                    ->setRole('ROLE_USER')
                    ->setService($service)
                        
                // on sette l'image avec le nom qu'on lui a donné
                    ->setPhoto($photoname)
                    ->setCarteIdentite($cniname)
                    ->setContratTravail($cdtname)
                        ;

                $em->persist($salarie);
                $em->flush();
                return $this->redirectToRoute('app_accueil_login');
            }
        }
        return $this->render('admin/ajout-salaries.html.twig',
                 [
                     //passage du formulaire a la vue
                     'form'=>$form->createView()
                 ]);
        
    }
    
    /**
     * 
     * @Route("/salarie-edit" )
     */
    public function salarieEdit()
    {
        return $this->render('admin/salarie-edit.html.twig');
    }
    
    /**
     * 
     * @Route("/liste-news" )
     */
    public function listeNews()
    {
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Actualite::class);
        $entreprise = $this->getUser()->getEntreprise();
        $actualite = $repository->findByEntreprise($entreprise);
        
        return $this->render('admin/liste-news.html.twig', [
            'actualite' => $actualite,
            
        ]);
    }
    
    /**
     * 
     * @Route("/edition-news/{id}", defaults={"id":null} )
     * @param Request $request
     */
    public function editNews(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
         
      
        $actualite= new Actualite();
        $actualite->setSalarie($this->getUser());
        $originalImage = null;
        
     
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);
       
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                /**
                  * @var uploadedFile 
                  */
                 $image = $actualite->getImage();
                 
                 //s'il y a eu une image uploadée
                 if(!is_null($image)){
                     // nom du fichoer que l'on va enregistrer
                    $filename = uniqid() . '.' . $image->guessExtension();
                    
                    $image->move(
                            // répertoire de destination
                            // cf config/services.yaml
                            $this->getParameter('upload_dir'),
                            $filename
                            
                    );
                    
                    // on sette l'image avec le nom qu'on lui a donné
                    $actualite->setImage($filename);
                    //die($actualite->getImage());
                    // suppression de l'ancienne image de l'article
                    // s'il on est en modification d'un article qui en avait
                    // déjà une 
                    /*
                    if(!is_null($originalImage)){
                        unlink($this->getParameter('upload_dir') . $originalImage);
                    }else{
                        // sans upload, on garde l'ancienne image
                        $actualite->setImage($originalImage);
                    }
                    */
                    $em->persist($actualite);
                    $em->flush();

                    $this->addFlash('success', 'L\'actualité est enregistré');

                    return $this->redirectToRoute('app_admin_listenews');

                }else{
                    $this->addFlash('error', 'Le formulaire contient des erreurs');
                }
            }
        }
        
        return $this->render('admin/edition-news.html.twig',
                [
                    'form'=>$form->createView(),
                    'original_image' => $originalImage
                ]);
        
        
    }
    
    
}