<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActualiteRepository")
 */
class Actualite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    
    /**
     * @Assert\NotBlank(message = "LE TITRE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $titre;
    

    
    /**
     *@Assert\NotBlank(message = "LE CONTENU EST OBLIGATOIRE")
     * @ORM\Column(type="text")
     */
    private $contenu;
    /**
     *@Assert\NotBlank(message = "LA DATE DE PUBLICATION EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $date;
    
    
    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="actualite") 
     */
    private $salarie;

    public function getId()
    {
        return $this->id;
    }
}
