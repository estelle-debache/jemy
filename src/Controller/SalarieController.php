<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Candidature;
use App\Entity\Conge;
use App\Entity\OffreEmploi;
use App\Entity\Salarie;
use App\Form\CandidatureType;
use App\Form\CongeType;
use App\Form\SalarieeditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
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
     * @Route("/profiledit" )
     */
    public function Profiledit(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       $salarie = $this->getUser();

       $originalImage = $salarie->getPhoto();
       $salarie->setPhoto(
            new File($this->getParameter('photo_dir') . '/' . $salarie->getPhoto())
        );

       $form = $this->createForm(SalarieeditType::class, $salarie);
       $form->handleRequest($request);


    if($form->isSubmitted())
    {
        if ($form->isValid()) {


                 /**
                  * @var uploadedFile
                  */
                 $photo = $salarie->getPhoto();

                 //s'il y a eu une image uploadée
                 if(!is_null($photo)){
                     // nom du fichoer que l'on va enregistrer
                    $filename = uniqid() . '.' . $photo->guessExtension();

                    $photo->move(
                            // répertoire de destination
                            // cf config/services.yaml
                            $this->getParameter('photo_dir'),
                            $filename

                    );
                    // on sette l'image avec le nom qu'on lui a donné
                    $salarie->setPhoto($filename);

                    // suppression de l'ancienne image de l'article
                    // s'il on est en modification d'un article qui en avait
                    // déjà une
                    if(!is_null($originalImage) && is_file($this->getParameter('photo_dir') . '/' . $originalImage)){
                        unlink($this->getParameter('photo_dir') . '/' . $originalImage);
                    }

                 }else{
                    // sans upload, on garde l'ancienne image
                    $salarie->setPhoto($originalImage);
                }
                // enregistrement en bdd
                $em->persist($salarie);
                $em->flush();

                // message de confirmation
                $this->addFlash(
                    'success',
                    'Votre profil a bien été modifié'
                );
                // redirection vers la page de liste
                return $this->redirectToRoute('app_salarie_monprofil');
        }
    }
        return $this->render('salarie/profiledit.html.twig',
                 [

                     'form'=>$form->createView()
                 ]);


    }
    

   


    /**
     *
     * @Route("/mes-conges")
     */
    public function mesconges(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Conge::class);
       
        $query = $repository->createQueryBuilder('c')->where('c.salarie='.$this->getUser()->getId())->getQuery();
        $conges= $query->getResult();
        dump($conges);
        
        $salarie = $this->getUser();
        
        
        $conge = new Conge();
        $conge
            ->setSalarie($salarie)
            ->setStatut('En cours')
        ;
        $countcongepayeencours= $repository->countByStatusAndSalarie($salarie);
        $countrttencours= $repository->countByStatusAndSalarie($salarie, 'En cours', 'RTT');
        
        
        $countcongepayeaccepte= $repository->countByStatusAndSalarie($salarie, 'validé');
        
        
        $countrttaccepte= $repository->countByStatusAndSalarie($salarie, 'validé', 'RTT');
        $form= $this->createForm(CongeType::class, $conge);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            if($form->isValid())
            {
          

                $em->persist($conge);
                $em->flush();
                $this->addFlash('success', 'Bonne vacances, revenez en forme');
                
                return $this->redirectToRoute('app_salarie_mesconges');
            }
        }
        return $this->render('salarie/mesconges.html.twig',
                [
                    'form'=>$form->createView(),
                    'ccpec'=> $countcongepayeencours,
                    'ccpa'=>$countcongepayeaccepte,
                    'crec'=>$countrttencours,
                    'cra'=>$countrttaccepte,
                    'conges'=>$conges
                ]
                );
    }
    
    /**
     * @Route("/modifconge/{id}")
     */
    public function modifconge(Request $request, Conge $conge) {
        
        $em=$this->getDoctrine()->getManager();
        
        $form= $this->createForm(CongeType::class, $conge);
        $form->handleRequest($request);
        
        if ($form->isSubmitted())
        {
            if($form->isValid())
            {
                $em->persist($conge);
                $em->flush();
                 $this->addFlash(
                    'success',
                    'Votre demande a bien été modifié'
                );
                 return $this->redirectToRoute('app_salarie_mesconges');
            }else{
                 $this->addFlash(
                    'error',
                    'Oups, le formulaire contient des erreurs'
                         
                );
                 return $this->redirectToRoute('app_salarie_mesconges');
            }
        }
        return $this->render('salarie/modifconge.html.twig',
                [
                    'form'=>$form->createView()
                    
                ]
                );
        
    }
    
    /**
     * 
     * @Route("/deleteconge/{id}")
     * 
     */
    public function deleteconge(Conge $conge) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($conge);
        $em->flush();
        
         
        $this->addFlash(
            'success',
            'Votre demande de congé est supprimée'
        );
        
        
        return  $this->redirectToRoute('app_salarie_mesconges');
        
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
        $entreprise = $this->getUser()->getEntreprise();
        $salaries = $repository->findByEntreprise($entreprise);


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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Actualite::class);
        $entreprise = $this->getUser()->getEntreprise();
        $actualites = $repository->findByEntreprise($entreprise);

        return $this->render('salarie/news.html.twig',
                [
                    'actualites' => $actualites
                ]);
    }

    /**
     *
     * @Route("/offres-emploi")
     */
    public function offresemploi()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(OffreEmploi::class);
        $entreprise = $this->getUser()->getEntreprise();
        $emploi = $repository->findBy(['entreprise'=> $entreprise],['datePublication'=> 'DESC']);

        return $this->render('salarie/offres-emploi.html.twig',
                [
                    'emploi' => $emploi
                ]);

    }

    /**
     *
     *
     * @Route("/offreemploidetail/{id}")
     */
    public function offreemploidetail(OffreEmploi $emploi, $id) {


        dump($emploi);
        return $this->render('salarie/offre-emploi-detail.html.twig',
               [
                   "emploi" => $emploi
               ]);
    }
    

    /**
     * 
     * @Route("/postuler/{id}")
     */
    public function postuler(Request $request, OffreEmploi $offreEmploi)
    {
        $em = $this->getDoctrine()->getManager();
        $candidature = new Candidature;
        $user= $this->getUser()->getId();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            if($form->isValid())
            {
                // recuperer le nom du fichier en bdd
                $cv = $candidature->getCv();
                // modifier le nom obtenue lors de la precedente action
                $cvname= $offreEmploi->getId().$user.'.'.$cv->guessExtension();
     
                //deplacement des fichiers vers les dossiers dans images
                $cv->move($this->getParameter('candidatures_dir'),$cvname);
                
                $candidature->setOffreEmploi($offreEmploi)
                            ->setSalarie($this->getUser())
                            ->setCv($cvname)
                            ->setEntreprise($this->getUser()->getEntreprise())
                        ;
                                
                               
                $em->persist($candidature);
                $em->flush();
                
                $this->addFlash(
                        'success',
                        'Votre candidature a bien été envoyée'
                    );


                return $this->redirectToRoute('app_salarie_offresemploi');

                
                
            }
        }
        
        return $this->render('salarie/postuler.html.twig',
                [
                    'form'=>$form->createView()
                ]
                );
    }
    
    /**
     * @Route("/fdp")
     */
    public function fdp()
    {
        
       return $this->render('salarie/mesfichesdepaie.html.twig');
    }
}
