<?php

namespace App\Form;

use App\Entity\OffreEmploi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffresemploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poste', TextType::class,['label'=> 'Intitulé du poste/métier'])
            ->add('contrat',  ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        ''=>'',
                        'CDI' => 'CDI',
                        'CDD' => 'CDD',
                        'ALTERNANCE'=>'ALTERNANCE',
                        'STAGE'=>'STAGE',
                           )))
                
            ->add('description', TextareaType::class,
                    [
                        'label' => 'Message'])
            ->add('date_publication', DateType::class,
                    [
                        'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'
                    ])
            ->add('salaire', TextType::class,['label'=>"salaire"])
            ->add('service', TextType::class,['label'=> 'service'])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreEmploi::class,
        ]);
    }
}
