<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Salarie;
use App\Form\ActualiteType;
use App\Form\SalarieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




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
         
        $form = $this->createForm(SalarieType::class, $salarie, ['validation_groups'=>'registration']);
        
        
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
     * @Route("/salarieedit" )
     */
    public function salarieedit()
    {
        return $this->render('admin/salarieedit.html.twig');
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
    public function editNews(Request $request, $id)
    {
         //Faire le rendu du formulaire et son traitement
        // Validation : tous les champs obligatoires
        // En creation setter l'auteur avec l'utilisateur connecté
        // $this->getUser()
        // Si enregistrement ok, rediriger vers la liste avec un message de confirmation
        
        $em = $this->getDoctrine()->getManager();
        $originalImage = null;
        
        if (is_null($id)) { // création
            $actualite = new Actualite();
            $actualite->setSalarie($this->getUser());
        } else { // modification
            $actualite = $em->find(Actualite::class, $id);
            
            // 404 si l'id reçu dans l'URL n'existe pas en bdd
            if (is_null($actualite)) {
                throw new NotFoundHttpException();
            }
            
            if(!is_null($actualite->getImage())){
            //nom du fichier en bdd
                $originalImage = $actualite->getImage();
                $actualite->setImage(
                        new File($this->getParameter('upload_dir') . $originalImage)
                 );
            }
        }
        
        // création d'un formulaire relié à la catégorie
        $form = $this->createForm(ActualiteType::class, $actualite);
        // le formulaire analyse la requête HTTP
        $form->handleRequest($request);
        
        // si le formulaire a été envoyé
        if ($form->isSubmitted()) {
            // les attributs de l'objet Catégory ont été
            // settés à partir des champs de formulaires
            //dump($category);
            
            // Valide la saisie du formulaire à partir
            // des annotations dans la classe Category
            if ($form->isValid()) {
                 /**
                  * @var uploadedFile 
                  */
                 $image = $actualite->getImage();
                 //s'il y a eu une image uploadée
                 if(!is_null($image)){
                     // nom du fichier que l'on va enregistrer
                    $filename = uniqid() . '.' . $image->guessExtension();
                    
                    $image->move(
                            // répertoire de destination
                            // cf config/services.yaml
                            $this->getParameter('upload_dir'),
                            $filename
                            
                    );
                    // on sette l'image avec le nom qu'on lui a donné
                    $actualite->setImage($filename);
                    
                    
                    // suppression de l'ancienne image de l'article
                    // s'il on est en modification d'un article qui en avait
                    // déjà une 
                    if(!is_null($originalImage)){
                        unlink($this->getParameter('upload_dir') . $originalImage);
                    }
                     
                 }else{
                        // sans upload, on garde l'ancienne image
                        $actualite->setImage($originalImage);
                    }
                // enregistrement en bdd
                $em->persist($actualite);
                $em->flush();
                
                // message de confirmation
                $this->addFlash(
                    'success',
                    'L\'article  est enregistrée'
                );
                // redirection vers la page de liste
                return $this->redirectToRoute('app_admin_listenews');
            } else {
                // message d'erreur en haut de la page
                $this->addFlash(
                    'error',
                    'Le formulaire contient des erreurs'
                );
            }
        }
        
        return $this->render(
            'admin/edition-news.html.twig',
            [
                // passage du formulaire à la vue
                'form' => $form->createView(),
                'original_image' => $originalImage
            ]
        );
        
    }
    
    /**
     * 
     * @Route("/delete/{id}")
     */
    public function delete(Actualite $actualite)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($actualite);
        $em->flush();
        
        $this->addFlash(
            'success',
            'L\'article est supprimée'
        );
        
        return $this->redirectToRoute('app_admin_listenews');
    }

    
    /**
     * 
     * @Route("/lesconges")
     */
    public function lesconges() {
        
        return $this->render('admin/lesconges.html.twig');
        
    }
    
    /**
     * @Route("/ajoutservice")
     */
    public function ajoutService(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        $service = new Service();
        
         $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        
           
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                 $service->setEntreprise($this->getUser()->getEntreprise());           
              
                    
                    
                $em->persist($service);
                $em->flush();

                $this->addFlash('success', 'Le service de salarié a été bien ajouté');

                return $this->redirectToRoute('app_admin_index');

                }
        
    }
     return $this->render('admin/ajoutservice.html.twig',
                [
                    'form'=>$form->createView(),
                   
                ]);
 
    
    
  }
}
