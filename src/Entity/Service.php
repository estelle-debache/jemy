<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Entreprise;
use App\Entity\Salarie;
use Symfony\Component\Validator\Constraints as Assert;
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
     *@Assert\NotBlank(message="LE NOM EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;
    
    
    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="services") 
     */
    private $entreprise;
    
    /**
     * @ORM\OneToMany(targetEntity="Salarie", mappedBy="service") 
     */
    private $salaries;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="OffreEmploi", mappedBy="service")
     */
    private $OffreEmploi;
    
    
    public function __construct() {
        $this->OffreEmploi = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salaries = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString() {
            return $this->nom;
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

    public function getSalaries() {
        return $this->salaries;
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

    public function setSalaries($salaries) {
        $this->salaries = $salaries;
        return $this;
    }

    public function setOffreEmploi($OffreEmploi) {
        $this->OffreEmploi = $OffreEmploi;
        return $this;
    }
    public function countByService() {
        return count($this->salaries);
        
    }


}
