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
                ->add(
                    // nom du champs qui doit correspondre au nom de l'attribut name de la classe Category
                    'nom',
                    //type de champs
                    TextType::class,// equivalent a un <input type="text">
                    //tableau d'options
                    [
                        //contenu de la balise label  
                        'label'=> 'nom'
                    ]
                    )
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
