<?php

namespace App\Form;

use App\Entity\Salarie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarieeditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('adresse', TextType::class,['label'=>"Adresse"])
            ->add('codePostal', TextType::class,['label'=>"Code Postal"])
            ->add('ville', TextType::class,['label'=>"Ville"])
            ->add('iban', TextType::class,['label'=>"IBAN (27 chiffres)"])
            ->add('telephone', TextType::class,['label'=>"Téléphone"])
            ->add('photo', FileType::class,['label'=>"Photo (portrait jpg)", 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
            'validation_groups' => array('edition')
        ]);
    }
}
