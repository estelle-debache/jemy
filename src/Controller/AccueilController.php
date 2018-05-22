<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Salarie;
use App\Entity\Service;
use App\Form\EntrepriseType;
use App\Form\SalarieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function dump;

/**
 * @Route("/")
 */
class AccueilController extends Controller
{
    /**
     * @Route("/" )
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
        $service = new Service();
        $service->setNom('RH');
        $entreprise->addService($service);// ca cree l'id dans entreprise_id de la table service grace a la methode add service dans entreprise
        dump($service);

        //creation d'un formulaire relié a la categorie
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        // le formulaire analyse la requete HTTP
        $form->handleRequest($request);

        //SI LE FORMULAIRE A ETE ENVOYE
        if( $form->isSubmitted())
        {
            if($form->isValid())
            {






            // RESTE PLKUS QUA LES METTRE EN BASE DE DONNéES
            $em->persist($entreprise);
            $em->persist($service);
            $em->flush();

            dump($entreprise->getId());



            $session = $request->getSession();

            $session->set('identreprise', $entreprise->getId());
            $session->set('idservice', $service->getId());

            $this->addFlash('success', " Félicitation ! Votre entreprise a bien été enregistrée  ");
            return $this->redirectToRoute('inscription-admin');
            }

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
        $idEntreprise = $session->get('identreprise');

        $salarie = new Salarie();

        $form = $this->createForm(SalarieType::class, $salarie, ['validation_groups'=>'registration']);


        $form->handleRequest($request);

        // recupere un objet entreprise ayant l'id enregistre en session lors de la creation de l'entreprise
        $entreprise = $em->find(Entreprise::class, $idEntreprise);

        // recupere un objet service ayant l'id enregistre en session lors de la creation de l'objet entreprise
        $service = $em->find(Service::class, $session->get('idservice'));
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
                    ->setRole('ROLE_ADMIN')
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
        return $this->render('accueil/inscription-admin.html.twig',
                 [
                     //passage du formulaire a la vue
                     'form'=>$form->createView()
                 ]);

    }

    /**
     *
     * @Route("/login" )
     */
    public function login(AuthenticationUtils $auth)
    {
        $error = $auth->getLastAuthenticationError();

        $lastUsername = $auth->getLastUsername();


        if(!empty($error))
        {
            $this->addFlash('error', 'Identifiants incorrects');
            dump($error);

        }
       // on  est redirige automatiquement vers app_index_index grace au fichier security.yaml
        return $this->render('accueil/connexion.html.twig',
                [
                    'last_username'=> $lastUsername
                ]
                );
    }
}
