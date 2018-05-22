<?php

namespace App\Form;

use App\Entity\OffreEmploi;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffresemploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poste', TextType::class,['label'=> 'Intitulé du poste'])
            ->add('contrat',  ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        ''=>'',
                        'CDI' => 'CDI',
                        'CDD' => 'CDD',

                           )))

            ->add('description', TextareaType::class,
                    [
                        'label' => 'Description du poste'])

            ->add('salaire', TextType::class,['label'=>"Salaire"])
            ->add('service', EntityType::class,[
                'label'=> 'Service',
                'class' => Service::class,
                'choice_label'=> 'nom',
                'placeholder' => 'Choisissez un service'

                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreEmploi::class,
        ]);
    }
}
