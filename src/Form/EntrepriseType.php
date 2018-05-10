<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               
                ->add('nom', TextType::class,['label'=> 'Nom'])
                ->add('siren', TextType::class,['label'=> 'Siren'])
                ->add('siret', TextType::class,['label'=> 'Siret'])
                
                ->add('adresse', TextType::class,['label'=> 'Adresse'])
                ->add('code_postal', TextType::class,['label'=> 'Code Postal'])
                ->add('ville', TextType::class,['label'=> 'Ville'])
                ->add('telephone', TextType::class,['label'=> 'Téléphone'])
                
                ->add('forme_juridique', ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        ''=>'',
                        'SARL' => 'SARL',
                        'SAS' => 'SAS',
                        'SA'=>'SA',
                           )))
                
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
