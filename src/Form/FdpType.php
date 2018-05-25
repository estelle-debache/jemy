<?php

namespace App\Form;

use App\Entity\FicheDePaie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FdpType extends AbstractType
{
    private $i;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $annees = [];
        
        for($i=1999; $i<=2050; $i++){
            $annes[$i] = $i;
        }
        
        $builder

            ->add('fiche_de_paie', FileType::class,['label'=>"Importez la fiche de paie"])
            
            ->add('mois',ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => array(
                        'Janvier'=>'Janvier',
                        'Fevrier'=>'Fevrier',
                        'Mars'=>'Mars',
                        'Avril'=>'Avril',
                        'Mai'=>'Mai',
                        'Juin'=>'Juin',
                        'Juillet'=>'Juillet',
                        'Aout'=>'Aout',
                        'Septembre'=>'Septembre',
                        'Octobre'=>'Octobre',
                        'Novembre'=>'Novembre',
                        'Decembre'=>'Decembre'
                        
                    )
                       ))
            ->add('annee', ChoiceType::class,array(
                    'expanded'=>false,
                    'multiple'=>false,
                    'choices' => $annes
                       ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheDePaie::class,
        ]);
    }
}
