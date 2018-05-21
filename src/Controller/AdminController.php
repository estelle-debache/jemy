<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Salarie;
use App\Form\ActualiteType;
use App\Form\AjoutsalarieType;
use App\Form\ModifsalarieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\File;



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
     * @Route("/listesalaries")
     */
    public function listesalaries()
    {
      
        return $this->render('admin/listesalaries.html.twig');
    }
   
     /**
     * 
     * @Route("/ajoutsalaries")
     */
    public function ajoutsalaries(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $salarie = new Salarie();
         
        $form = $this->createForm(AjoutsalarieType::class, $salarie );
        
        
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
                $cniname=$salarie->getNumSs().'.'.$cni->guessExtension();
                $cdtname= $salarie->getNumSs().'.'.$cdt->guessExtension();
                
                
                //deplacement des fichiers vers les dossiers dans images 
                
                $photo->move($this->getParameter('photo_dir'),$photoname);
                $cni->move($this->getParameter('cni_dir'),$cniname);
                $cdt->move($this->getParameter('cdt_dir'),$cdtname);
                
                // encodage du password
                $password = $passwordEncoder->encodePassword($salarie, $salarie->getplainPassword());
                $salarie
                    ->setPassword($password)
                    ->setEntreprise($entreprise)
                 
                    ->setService($service)
                        
                // on sette l'image avec le nom qu'on lui a donné
                    ->setPhoto($photoname)
                    ->setCarteIdentite($cniname)
                    ->setContratTravail($cdtname)
                        ;

                $em->persist($salarie);
                $em->flush();
                return $this->redirectToRoute('app_admin_listesalaries');
            }
        }
        return $this->render('admin/ajoutsalaries.html.twig',
                 [
                     //passage du formulaire a la vue
                     'form'=>$form->createView()
                 ]);
        
    }
    
    /**
     * 
     * @Route("/salarieedit/{id}" )
     */
    public function modifsalarie(Request $request, Salarie $salarie, $id) {
        $em= $this->getDoctrine()->getManager();
        
        $salarie = $em->find(Salarie::class , $id);
        
     
      $originalphoto = $salarie->getPhoto();
      $originalcdt = $salarie->getContratTravail();
      $originalcni = $salarie->getCarteIdentite();
      $salarie->setPhoto(
           new File($this->getParameter('photo_dir') . '/' . $salarie->getPhoto()))
              ->setContratTravail(
           new File($this->getParameter('cdt_dir') . '/' . $salarie->getContratTravail()))
              ->setCarteIdentite(
           new File($this->getParameter('cni_dir') . '/' . $salarie->getCarteIdentite())) 
              
              ;
     
      $form = $this->createForm(ModifsalarieType::class, $salarie);
      $form->handleRequest($request);
     
        if($form->isSubmitted())
        {
            if ($form->isValid()) {
                     /**
                      * @var uploadedFile
                      */
                     $photo = $salarie->getPhoto();
                     $cdt = $salarie->getContratTravail();
                     $cni = $salarie->getCarteIdentite();


                     //s'il y a eu une image uploadée
                     if(!is_null($photo)&& !is_null($cni)&& !is_null($cdt)){
                         // nom du fichoer que l'on va enregistrer
                        $photoname = uniqid() . '.' . $photo->guessExtension();
                        $cdtname = uniqid() . '.' . $cdt->guessExtension();
                        $cniname = uniqid() . '.' . $cni->guessExtension();
                        $photo->move(
                                // répertoire de destination
                                // cf config/services.yaml
                                $this->getParameter('photo_dir'),$photoname);
                        $cdt->move(
                                // répertoire de destination
                                // cf config/services.yaml
                                $this->getParameter('cdt_dir'),$cdtname);
                        $cni->move(
                                // répertoire de destination
                                // cf config/services.yaml
                                $this->getParameter('cni_dir'),$cniname);


                        // on sette l'image avec le nom qu'on lui a donné
                        $salarie->setPhoto($photoname)
                                ->setCarteIdentite($cniname)
                                ->setContratTravail($cdtname)

                                ;

                        // suppression de l'ancienne image de l'article
                        // s'il on est en modification d'un article qui en avait
                        // déjà une
                        if(!is_null($originalphoto) && is_file($this->getParameter('photo_dir') . '/' . $originalphoto)){
                            unlink($this->getParameter('photo_dir') . '/' . $originalphoto);
                        }
                        if(!is_null($originalcdt) && is_file($this->getParameter('cdt_dir') . '/' . $originalcdt)){
                            unlink($this->getParameter('photo_dir') . '/' . $originalcdt);
                        }
                        if(!is_null($originalcni) && is_file($this->getParameter('photo_cni') . '/' . $originalcni)){
                            unlink($this->getParameter('photo_dir') . '/' . $originalcni);
                        }

                     }else{
                        // sans upload, on garde l'ancienne image
                        $salarie->setPhoto($originalphoto);
                        $salarie->setContratTravail($originalcdt);
                        $salarie->setCarteIdentite($originalcni);
                    }

                    $salarie->setEntreprise($this->getUser()->getEntreprise());

                    // enregistrement en bdd
                    $em->persist($salarie);
                    $em->flush();

                    // message de confirmation
                    $this->addFlash(
                        'success',
                        'Le profil a bien été modifié'
                    );
                    // redirection vers la page de liste
                    return $this->redirectToRoute('app_admin_listesalaries');
            }
        }
       return $this->render('admin/modifsalarie.html.twig',
                [
                   
                    'salarie'=>$form->createView(),
                    'original_photo' => $originalphoto,
                    'original_cdt' => $originalcdt,
                    'original_cni' => $originalcni
                ]);
       
   
}
    
    /**
     * 
     * @param Salarie $salarie
     * @Route("/salarieprofil/{id}")
     */
    public function salarieprofil(Salarie $salarie, $id) {
       
        
        
        return $this->render('admin/salarieprofil.html.twig', 
               [
                   "salarie" => $salarie
               ]);
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
    
    /**
     * 
     * @Route("/lesconges")
     */
    public function lesconges() {
        
        return $this->render('admin/lesconges.html.twig');
        
    }
    
    
    
    
    
}
