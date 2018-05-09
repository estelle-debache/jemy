<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nom;
    
    
    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="service") 
     */
    private $entreprise;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Salarie", mappedBy="service")
     */
    private $salarie;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="OffreEmploi", mappedBy="service")
     */
    private $OffreEmploi;
    
    
    
    
    

    public function getId()
    {
        return $this->id;
    }
}
