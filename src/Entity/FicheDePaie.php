<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheDePaieRepository")
 */
class FicheDePaie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
   
    /*
     * @ORM\Column(type="date")
     */
    private $date_emission;
    /**
     * @Assert\NotBlank(message = "LE MOIS EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=20)
     */
    private $mois;
    
    /**
     * @Assert\NotBlank(message = "LE FICHE DE PAIE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $fiche_de_paie;
    /**
     *
     * @ORM\Column(type="date")
     */
    private $dateEmission;
    
    /**
     *
     *  @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="FicheDePaie") 
     */
    private $salarie;
    
    
    

    public function getId()
    {
        return $this->id;
    }
}
