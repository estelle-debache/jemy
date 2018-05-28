<?php

namespace App\Form;

use App\Entity\Conge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongeadminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statut', ChoiceType::class,array(
                'expanded'=>false,
                'multiple'=>false,
                'choices' => array(
                    ''=>'',
                    'en cours' => 'en cours',
                    'validé' => 'validé',
                    'refusé'=> 'refusé'
                       ),
                'label'=> 'Accepté / refusé'
                ))




            ->add('comment', TextareaType::class,
                    [
                       'label'=> 'Votre commentaire'
                    ]
                )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
