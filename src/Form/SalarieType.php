<?php

namespace App\Form;

use App\Entity\Salarie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', TextType::class,['label'=>"eMail"])
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
            ->add('date_de_naissance', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ))
             
            ->add('adresse', TextType::class,['label'=>"Adresse"])
            ->add('code_postale', TextType::class,['label'=>"Code Postale"])
            ->add('ville', TextType::class,['label'=>"Ville"])
            ->add('date_embauche', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ))
            ->add('num_ss', TextType::class,['label'=>"Numero Securite Social"])
            ->add('role', ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        ''=>'',
                        'Admin' => 'admin',
                        'User' => 'user',
                        
                           )))
            ->add('iban', TextType::class,['label'=>"IBAN"])
            ->add('carte_identite', TextType::class,['label'=>"Carte d'identite"])
            ->add('contrat_travail', TextType::class,['label'=>"Contrat de travail"])
            ->add('photo', TextType::class,['label'=>"Photo"])
            ->add('solde_conge', TextType::class,['label'=>"Solde conge"])
            ->add('statut', ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        ''=>'',
                        'En Activite' => 'en activite',
                        'Fin de contrat' => 'fin de contrat',
                        
                           )))
            ->add('date_fin_contrat', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                ))
            ->add('entreprise')
            ->add('service')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
        ]);
    }
}
