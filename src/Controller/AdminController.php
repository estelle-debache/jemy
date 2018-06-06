<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Conge;
use App\Entity\Entreprise;
use App\Entity\FicheDePaie;
use App\Entity\OffreEmploi;
use App\Entity\Recuperation;
use App\Entity\Salarie;
use App\Entity\Service;
use App\Form\ActualiteType;
use App\Form\AjoutsalarieType;
use App\Form\CongeadminType;
use App\Form\EntrepriseType;
use App\Form\FdpType;
use App\Form\ModifsalarieType;
use App\Form\OffresemploiType;
use App\Form\ServiceType;
use Swift_Mailer;
use Swift_Message;
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
    public function ajoutsalaries(Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $salarie = new Salarie();
        $salarie->setStatut('en activite');
         
        $form = $this->createForm(AjoutsalarieType::class, $salarie );
        
        
        $form->handleRequest($request);
        
        // recupere un objet entreprise ayant l'id enregistre en session lors de la creation de l'entreprise 
        $entreprise = $this->getUser()->getEntreprise();
        
        // recupere un objet service ayant l'id enregistre en session lors de la creation de l'objet entreprise

        
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
                    
                        
                // on sette l'image avec le nom qu'on lui a donné
                    ->setPhoto($photoname)
                    ->setCarteIdentite($cniname)
                    ->setContratTravail($cdtname)
                        ;
        $recuperation = new Recuperation();
        $recuperation
                ->setSalarie($salarie)
                ->setUniq(uniqid())
                ;
                
        
        $message = (new Swift_Message('JEMY-RH essayer c\'est l\'adopter'))
        ->setFrom('tendances.im@gmail.com', 'Meir Bloemhof')
        ->setTo($salarie->getEmail())
        ->setBody(
            $this->renderView(
                // templates/emails/inscription.html.twig
                'emails/inscription.html.twig',
                array('name' => $salarie->getFullName(),
                       'recuperation' => $recuperation
                    )
            ),
            'text/html'
        );
         $mailer->send($message);
                
                
                
                
                $em->persist($salarie);
                $em->persist($recuperation);
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
      $salarie->setPhoto(new File($this->getParameter('photo_dir') . '/' .$originalphoto));
      $salarie->setContratTravail(new File($this->getParameter('cdt_dir') . '/' . $originalcdt));
      $salarie->setCarteIdentite(new File($this->getParameter('cni_dir') . '/' . $originalcni)) ;
     
      $form = $this->createForm(ModifsalarieType::class, $salarie, ['validation_groups'=>'edition-admin']);
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
                     if(!is_null($photo)){
                         // nom du fichoer que l'on va enregistrer
                        $photoname = uniqid() . '.' . $photo->guessExtension();
                        
                        
                        $photo->move(
                                // répertoire de destination
                                // cf config/services.yaml
                                $this->getParameter('photo_dir'),$photoname);
                        
                        $salarie->setPhoto($photoname);
                        
                        if(!is_null($originalphoto)){
                            unlink($this->getParameter('photo_dir') . '/' . $originalphoto);
                        }
                     } else{
                        // sans upload, on garde l'ancienne image
                        $salarie->setPhoto($originalphoto);
                    }
                        
                    if(!is_null($cdt)){
                        $cdtname = uniqid() . '.' . $cdt->guessExtension();
                        
                        $cdt->move(
                                // répertoire de destination
                                // cf config/services.yaml
                                $this->getParameter('cdt_dir'),$cdtname);
                        $salarie->setContratTravail($cdtname);
                        
                        if(!is_null($originalcdt)){
                            unlink($this->getParameter('cdt_dir') . '/' . $originalcdt);
                        }
                        }else{
                        // sans upload, on garde l'ancienne image
                        $salarie->setContratTravail($originalcdt);
                        
                    }
                        
                        
                    if(!is_null($cni)){
                        $cniname = uniqid() . '.' . $cni->guessExtension();
                        
                        $cni->move(
                                // répertoire de destination
                                // cf config/services.yaml
                                $this->getParameter('cni_dir'),$cniname);
                        $salarie->setCarteIdentite($cniname);
                        
                        if(!is_null($originalcni)){
                            unlink($this->getParameter('cni_dir') . '/' . $originalcni);
                        }
                        }else{
                        // sans upload, on garde l'ancienne image
                        $salarie->setCarteIdentite($originalcni);
                    }
                        
                        


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
                        new File($this->getParameter('upload_dir'). "/" . $originalImage)
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
                        unlink($this->getParameter('upload_dir'). "/" . $originalImage);
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
     * @Route("/liste-emploi" )
     */
    public function listeEmploi()
    {
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(OffreEmploi::class);
        $entreprise = $this->getUser()->getEntreprise();
        $emploi = $repository->findByEntreprise($entreprise);
        
        return $this->render('admin/liste-emploi.html.twig', [
            'emploi' => $emploi,
            
        ]);
    }
    
    /**
     * 
     * @Route("/liste-candidature" )
     */
    public function listeCandidature()
    {
        return $this->render('admin/liste-candidature.html.twig');
       
            
        
    }
    
    /**
     * 
     * @Route("/edition-emploi/{id}", defaults={"id":null} )
     * @param Request $request
     */
    public function editEmploi(Request $request, $id)
    {
         //Faire le rendu du formulaire et son traitement
        // Validation : tous les champs obligatoires
        // En creation setter l'auteur avec l'utilisateur connecté
        // $this->getUser()
        // Si enregistrement ok, rediriger vers la liste avec un message de confirmation
        
        $em = $this->getDoctrine()->getManager();
        
        
        if (is_null($id)) { // création
            $emploi = new OffreEmploi();
            $emploi->setEntreprise($this->getUser()->getEntreprise());
        } else { // modification
            $emploi = $em->find(OffreEmploi::class, $id);
            
            // 404 si l'id reçu dans l'URL n'existe pas en bdd
            if (is_null($emploi)) {
                throw new NotFoundHttpException();
            }
            
            
        }
        
        // création d'un formulaire relié à la catégorie
        $form = $this->createForm(OffresemploiType::class, $emploi);
        // le formulaire analyse la requête HTTP
        $form->handleRequest($request);
        
        // si le formulaire a été envoyé
        if ($form->isSubmitted()) {
            // les attributs de l'objet Catégory ont été
            // settés à partir des champs de formulaires
            
            
            // Valide la saisie du formulaire à partir
            // des annotations dans la classe Category
            if ($form->isValid()) {
                 /**
                  * @var uploadedFile 
                  */
                
                // enregistrement en bdd
                $em->persist($emploi);
                $em->flush();
                
                // message de confirmation
                $this->addFlash(
                    'success',
                    'L\'offre d\'emploi est enregistrée'
                );
                // redirection vers la page de liste
                return $this->redirectToRoute('app_admin_listeemploi');
            } else {
                // message d'erreur en haut de la page
                $this->addFlash(
                    'error',
                    'Le formulaire contient des erreurs'
                );
            }
        }
        
        return $this->render(
            'admin/edition-emploi.html.twig',
            [
                // passage du formulaire à la vue
                'form' => $form->createView(),
                
            ]
        );
        
    }
    
    /**
     * 
     * @Route("/delete-emploi/{id}")
     */
    public function deleteEmploi(OffreEmploi $emploi)
    {
        $nbcandidatures = $emploi->countByCandidatures();
        if($nbcandidatures == 0 ){
        $em = $this->getDoctrine()->getManager();
        $em->remove($emploi);
        $em->flush();
        
        $this->addFlash(
            'success',
            'L\'offre d\'emploi est supprimée'
        );
        } else{
            $this->addFlash(
            'error',
            'L\'offre d\'emploi ne peut être supprimée, il y a des candidatures en cours'
        );
        }
        return $this->redirectToRoute('app_admin_listeemploi');
    }
    /**
     * 
     * @Route("/delete-news/{id}")
     */
    public function deleteNews(Actualite $actualite)
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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Conge::class);
        
        $entreprise = $this->getUser()->getEntreprise();
        
        $demandesencours = $repository->findAllcongesByEntreprise($entreprise, 'en cours');
        $demandesvalidees = $repository->findAllcongesByEntreprise($entreprise, 'validé');
        $demandesrefusees = $repository->findAllcongesByEntreprise($entreprise, 'refusé');
        $nbdemandes =$repository->countAllcongesByEntreprise($entreprise, 'en cours');

        
        
        return $this->render('admin/lesconges.html.twig',
                [
                    'demandes'=>$demandesencours,
                    'demandesvalides'=>$demandesvalidees,
                    'demandesrefusees'=>$demandesrefusees,
                    'nbdemandes'=>$nbdemandes
                ]
                
                );
        
    }
    /**
     * 
     * @Route("/reponseconge/{id}")
     */
    public function reponseconge(Request $request, Conge $conge) {
        
        $em=$this->getDoctrine()->getManager();
        
        
        
        
        $form= $this->createForm(CongeadminType::class, $conge);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            if($form->isValid())
            {
                $typeconge= $conge->getTypeconge();
                $statut = $conge->getStatut();
                $soldeconge= $conge->getSalarie()->getSoldeConge();
                $soldertt = $conge->getSalarie()->getSoldeRtt(); 
                $diminution = $conge->getNbdejour();
                
                if($typeconge == 'Congé payé')
                {
                    if($statut=='validé')
                    {
                        $conge->getSalarie()->setSoldeConge($soldeconge-$diminution);

                    }
                }
                if($typeconge == 'RTT')
                {
                    if($statut=='validé')
                    {
                        $conge->getSalarie()->setSoldeRtt($soldertt-$diminution);

                    }
                }
                
                
                
                
               $em->persist($conge);
               $em->flush();
               return $this->redirectToRoute('app_admin_lesconges');
            }
        }
        
        
        return $this->render('admin/reponseconge.html.twig',
                       [
                           'form'=> $form->createView()
                           
                       ]
                );
        
    }
    
    
    
    /**
     * @Route("/ajoutservice")
     */
    public function ajoutservice(Request $request) 
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

                $this->addFlash('success', 'Le service a bien été ajouté');

                return $this->redirectToRoute('app_admin_entrepriseconnectee');

                }
        
         }
     return $this->render('admin/ajoutservice.html.twig',
                [
                    'form'=>$form->createView(),
                                  
                ]);  
    }
    
    /**
     * 
     * @Route("/editservice/{id}")
     */
    public function editservice(Request $request, Service $service, $id) {
        
        $em = $this->getDoctrine()->getManager();
        $service = $em->find(Service::class, $id);
        
        
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($service);
                $em->flush();
                
                
                $this->addFlash(
                    'success',
                    'Le service a bien été modifié'
                );
                
                return $this->redirectToRoute('app_admin_entrepriseconnectee');
            } else {
                
                $this->addFlash(
                    'error',
                    'Le formulaire contient des erreurs'
                );
            }
        }
       
        return $this->render(
            'admin/editservice.html.twig',
            [
                
                'form' => $form->createView(),
                
            ]
        );
    }
    
    /**
     * 
     * @Route("/deleteservice/{id}")
     */
    public function deleteservice(Service $service)
    {
        $nbsalaries = $service->countByService();
        if($nbsalaries == 0 ){
                
        $em = $this->getDoctrine()->getManager();
        
        $service->
        
        
        $em->remove($service);
        $em->flush();
        
        $this->addFlash(
            'success',
            'Le service est bien supprimé'
        );
        } else{
            $this->addFlash(
            'error',
            'Impossible de supprimer le service, Vous devez d\'abord supprimer les salariés ou les changer de service'
            );
            
        }
        return $this->redirectToRoute('app_admin_entrepriseconnectee');
    }
      
     /**
     * 
     * @Route("/entreprise/{id}")
     */
    public function entreprise(Entreprise $entreprise, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Service::class);
       
        
        return $this->render('admin/entreprise.html.twig',
                [
                    "entreprise" => $entreprise
                ]);
    }
    
    
    
    
    /**
    * @Route("/modifentreprise/{id}")
    */
    public function modifentreprise(Request $request, Entreprise $entreprise, $id) {
        $em= $this->getDoctrine()->getManager();
        
        $entreprise = $em->find(Entreprise::class , $id);
         
        //creation d'un formulaire relié a la categorie
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        // le formulaire analyse la requete HTTP
        $form->handleRequest($request);
        
        //SI LE FORMULAIRE A ETE ENVOYE 
        if( $form->isSubmitted())
        {
            if($form->isValid())
            {
                $em->persist($entreprise);
                $em->flush();
                return $this->redirectToRoute('app_admin_entrepriseconnectee');
            }
        }
        return $this->render('admin/modifentreprise.html.twig',
                [
                    'form' => $form->createView()
                ]
                );
    }
    /**
     * @Route("/entrepriseconnectee")
     */
    public function entrepriseconnectee()
    {
        
        
       return $this->render('admin/entrepriseconnectee.html.twig'); 
    }
    
    /**
     * 
     * @Route("/liste-candidatures/{id}")
     */
    public function listecandidatures(OffreEmploi $emploi) {
        
        return $this->render('admin/liste-candidatures.html.twig', [
            
            'emploi' => $emploi,
            
        ]);
    
   }
   
   /**
    * @Route("/insertfdp/{id}")
    */
   public function insertfdp(Request $request, Salarie $salarie, $id) {
       
       $em =$this->getDoctrine()->getManager();
       
       $soldertt= $salarie->getSoldeRtt();
       $soldeconge = $salarie->getSoldeConge();
        
       
       
       
       

       $repository = $this->getDoctrine()->getRepository(FicheDePaie::class);
       
        $query = $repository->createQueryBuilder('f')->where('f.salarie='.$salarie->getId())->getQuery();
        $fichede= $query->getResult();

       
       $fdp = new FicheDePaie();
       
       
       $form = $this->createForm(FdpType::class, $fdp);
       $form->handleRequest($request);
       
       if($form->isSubmitted()){
           if($form->isValid())
           {
                $soldeconge+=2.5;
                $soldertt+= 1;
                $salarie->setSoldeConge($soldeconge)
                        ->setSoldeRtt($soldertt);
               
                
               
                // recuperer le nom du fichier en bdd
                $blo = $fdp->getFicheDePaie();
                 // modifier le nom obtenue lors de la precedente action
                $bloname= uniqid() . '.' . $blo->guessExtension();
                
                $blo->move($this->getParameter('fdp_dir'),$bloname);
                
                $fdp->setFicheDePaie($bloname)
                    ->setSalarie($salarie)
                        ;


 
               
            $em->persist($fdp);
            $em->flush();
            $this->addFlash(
                    'success',
                    'La fiche de paie a bien été enregistrée'
                );
           return $this->redirectToRoute('app_admin_insertfdp', array('id'=>$salarie->getId()));
 
               
           }
       }
       
       
       return $this->render('admin/insertfdp.html.twig',
               [
                   'form'=>$form->createView(),
                   'fichede'=>$fichede
               ]
               
               );
       
       
   }     
   
   
  /**
     * 
     * @Route("/edition-fdp/{id}", defaults={"id":null} )
     * @param Request $request
     */
   
    public function editfdp(Request $request, FicheDePaie $fdp)
    {
         //Faire le rendu du formulaire et son traitement
        // Validation : tous les champs obligatoires
        // En creation setter l'auteur avec l'utilisateur connecté
        // $this->getUser()
        // Si enregistrement ok, rediriger vers la liste avec un message de confirmation
        
        $em = $this->getDoctrine()->getManager();
        $originalfdp = null;
        
       
            
            
            // 404 si l'id reçu dans l'URL n'existe pas en bdd
            if (is_null($fdp)) {
                throw new NotFoundHttpException();
            }
            
            if(!is_null($fdp->getFicheDePaie())){
            //nom du fichier en bdd
                $originalfdp = $fdp->getFicheDePaie();
                $fdp->setFicheDePaie(
                        new File($this->getParameter('fdp_dir') . $originalfdp)
                 );
            }
      
        // création d'un formulaire relié à la catégorie
        $form = $this->createForm(FdpType::class, $fdp);
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
   
                 $newfdp = $fdp->getFicheDePaie();
                 //s'il y a eu une image uploadée
                 if(!is_null($newfdp)){
                     // nom du fichier que l'on va enregistrer
                    $filename = uniqid() . '.' . $newfdp->guessExtension();
                    
                    $newfdp->move(
                            // répertoire de destination
                            // cf config/services.yaml
                            $this->getParameter('fdp_dir'),
                            $filename
                            
                    );
                    // on sette l'image avec le nom qu'on lui a donné
                    $fdp->setFicheDePaie($filename);
                    
                    
                    // suppression de l'ancienne image de l'article
                    // s'il on est en modification d'un article qui en avait
                    // déjà une 
                    if(!is_null($originalfdp)){
                        unlink($this->getParameter('fdp_dir') . $originalfdp);
                    }
                     
                 }else{
                        // sans upload, on garde l'ancienne image
                        $fdp->setFicheDePaie($originalfdp);
                    }
                // enregistrement en bdd
                $em->persist($fdp);
                $em->flush();
                
                // message de confirmation
                $this->addFlash(
                    'success',
                    'La fiche de paie à bien été modifiée'
                );
                // redirection vers la page de liste
                return $this->redirectToRoute('app_admin_insertfdp', array('id'=>$fdp->getSalarie()->getId()));
            } else {
                // message d'erreur en haut de la page
                $this->addFlash(
                    'error',
                    'Le formulaire contient des erreurs'
                );
            }
        }
        
        return $this->render(
            'admin/edition-fdp.html.twig',
            [
                // passage du formulaire à la vue
                'form' => $form->createView(),
                'original_fdp' => $originalfdp,
                
              
            ]
        );
        
    }
    
    /**
     * 
     * @Route("/deletefdp/{id}")
     */
    public function deletefdp(FicheDePaie $fdp)
    {
        $em =$this->getDoctrine()->getManager();
        $em->remove($fdp);
        $em->flush();
        
        $this->addFlash(
            'success',
            'La fiche de paie a été supprimée'
        );
        
        return $this->redirectToRoute('app_admin_insertfdp', array('id'=> $fdp->getSalarie()->getId()));
    }
    
    
          

}
