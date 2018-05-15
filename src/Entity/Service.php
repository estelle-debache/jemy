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
    
    
    public function __construct() {
        $this->OffreEmploi = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salarie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    

    public function getId()
    {
        return $this->id;
    }
    public function getNom() {
        return $this->nom;
    }

    public function getEntreprise() {
        return $this->entreprise;
    }

    public function getSalarie() {
        return $this->salarie;
    }

    public function getOffreEmploi() {
        return $this->OffreEmploi;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setEntreprise($entreprise) {
        $this->entreprise = $entreprise;
        return $this;
    }

    public function setSalarie($salarie) {
        $this->salarie = $salarie;
        return $this;
    }

    public function setOffreEmploi($OffreEmploi) {
        $this->OffreEmploi = $OffreEmploi;
        return $this;
    }


}
