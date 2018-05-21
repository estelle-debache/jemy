<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('titre', TextType::class,
                    [
                        'label'=> 'Titre'
                    ]
                )
            ->add('contenu', TextareaType::class,
                    [
                       'label'=> 'Contenu'
                    ]
                )
            // $builder->geData() retourne $actualite
            // si ID est null(car actualité pas créer) alors l'image est requise 
            ->add('image', FileType::class,['label'=>"image", 'required' => is_null($builder->getData()->getId())])
            
                

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
