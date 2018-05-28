<?php

namespace App\Form;

use App\Entity\Salarie;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AjoutsalarieType extends AbstractType
{
    private $entreprise; 
    function __construct(TokenStorageInterface $tokenStorage) {
        $this->entreprise = $tokenStorage->getToken()->getUser()->getEntreprise();         
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite', ChoiceType::class,array(
                'expanded'=>false,
                'multiple'=>false,
                'choices' => array(
                    ''=>'',
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',

                       )))
            ->add('nom', TextType::class,['label'=>"Nom"])
            ->add('prenom', TextType::class,['label'=>"Prenom"])
            ->add('service', EntityType::class, 
                    [
                        'label' => 'Service',
                        // nom de l'entité
                        'class' => Service::class,
                        // nom de l(attribut utilisé pour l'affichage des options
                        'query_builder' => function(\Doctrine\ORM\EntityRepository $er){
                            return $er->createQueryBuilder("s")
                                     ->where('IDENTITY(s.entreprise)=' . $this->entreprise->getId());              
                        },
                        // pour avoir une 1ère option vide
                        'placeholder' =>' Choisissez un service'
                    ])
            ->add('role', ChoiceType::class,array(
                   
                    'choices' => array(
                        ''=>'',
                        'Admin' => 'ROLE_ADMIN',
                        'Employé' => 'ROLE_USER',
                  )))
            ->add('dateDeNaissance', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ))
            ->add('email', EmailType::class,['label'=>"Email"])
            ->add('plainPassword',
                    //2champs qui doivent avoir la meme valeur
                    RepeatedType::class,
                    [
                        'type'=> PasswordType::class,
                        'first_options'=> [
                            'label'=> 'Mot de passe'
                        ],
                        'second_options'=>  [
                            'label'=>'Confirmation du mot de passe'
                        ]
                    ]
                    )
            
           
             
            ->add('adresse', TextType::class,['label'=>"Adresse"])
            ->add('codePostal', TextType::class,['label'=>"Code Postal"])
            ->add('ville', TextType::class,['label'=>"Ville"])
            ->add('dateEmbauche', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ))
            ->add('numSs', TextType::class,['label'=>"Numero Securite Social (15 chiffres)"])
            
            ->add('iban', TextType::class,['label'=>"IBAN (27 chiffres)"])
            ->add('carteIdentite', FileType::class,['label'=>"Carte d'identite (jpg)"])
            ->add('contratTravail', FileType::class,['label'=>"Contrat de travail (pdf)"])
            ->add('photo', FileType::class,['label'=>"Photo (portrait jpg)"])
            ->add('telephone', TextType::class,['label'=>"Téléphone"])


           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
            'validation_groups' => array('edition'),
        ]);
    }
}
