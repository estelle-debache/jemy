<?php

namespace App\Form;

use App\Entity\Salarie;
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


class ModifsalarieType extends AbstractType
{
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
            //->add('service', TextType::class,['label'=>"Service"])
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
             
            ->add('adresse', TextType::class,['label'=>"Adresse"])
            ->add('codePostal', TextType::class,['label'=>"Code Postal"])
            ->add('ville', TextType::class,['label'=>"Ville"])
            
            ->add('iban', TextType::class,['label'=>"IBAN"])
            ->add('carteIdentite', FileType::class,['label'=>"Carte d'identite", 'required' => false])
            ->add('contratTravail', FileType::class,['label'=>"Contrat de travail", 'required' => false])
            ->add('photo', FileType::class,['label'=>"Photo", 'required' => false])
            ->add('telephone', TextType::class,['label'=>"Téléphone"])
            ->add ('dateFinContrat', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ))
            ->add('statut',ChoiceType::class,array(
                   
                    'choices' => array(
                        'En activité' => 'en activité',
                        'Fin de contrat' => 'fin de contrat',
                  )))


                
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
            'validation_groups' => array('edition-admin'),
        ]);
    }
}