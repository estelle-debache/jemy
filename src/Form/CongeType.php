<?php

namespace App\Form;

use App\Entity\Conge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\IntegerTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('datedebut', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                    'label'=> 'Date de début'
                ) )
            ->add('datefin', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
                    'label'=> 'Date de fin'
                ))
            ->add('nbdejour', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class,
                    [
                        'label'=>'Nombre de jour demandé'
                    ]
                    )

            ->add('typeconge', ChoiceType::class,array(
                'expanded'=>false,
                'multiple'=>false,
                'choices' => array(
                    ''=>'',
                    'RTT' => 'RTT',
                    'Congé payé' => 'Congé payé',
                       ),
                'label'=> 'Type de congé'
                ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
