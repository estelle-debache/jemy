<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               
                ->add('nom', TextType::class,['label'=> 'nom'])
                ->add('siren', IntegerType::class,['label'=> 'siren'])
                ->add('siret', IntegerType::class,['label'=> 'siret'])
                ->add('forme_juridique', TextType::class,['label'=> 'form_juridique'])
                ->add('adresse', TextType::class,['label'=> 'adresse'])
                ->add('code_postal', IntegerType::class,['label'=> 'code_postal'])
                ->add('ville', TextType::class,['label'=> 'ville'])
                ->add('telephone', TelType::class,['label'=> 'telephone'])
                
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
