<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               
                ->add('nom', TextType::class,['label'=> 'Nom'])
                ->add('siren', TextType::class,['label'=> 'Siren (9 chiffres)'])
                ->add('siret', TextType::class,['label'=> 'Siret (14 chiffres)'])
                
                ->add('adresse', TextType::class,['label'=> 'Adresse'])
                ->add('codePostal', TextType::class,['label'=> 'Code Postal'])
                ->add('ville', TextType::class,['label'=> 'Ville'])
                ->add('telephone', TextType::class,['label'=> 'Téléphone'])
                
                ->add('formeJuridique', ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        '' => '',
                        'SARL' => 'SARL',
                        'SAS' => 'SAS',
                        'SA'=>'SA',
                           )))
                ->add('nbcpgagne', TextType::class, ['label'=> 'congé payé'])
                ->add('nbrttgagne', TextType::class, ['label'=> 'RTT'])
                ->add('logo', FileType::class, ['label'=>'Logo de l\'entreprise'])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,          
        ]);
    }
}
