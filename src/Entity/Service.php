<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Entreprise;
use App\Entity\Salarie;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id;
    
    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;
    
    
    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="service") 
     */
    private $entreprise;
    
    /**
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
