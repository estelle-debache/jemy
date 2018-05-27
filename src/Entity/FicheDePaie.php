<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
     * @Assert\NotBlank(message="LE FICHE DE PAIE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $ficheDePaie;
    /**
     *
     *  @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="FicheDePaies") 
     */
    private $salarie;
    
    /**
     *
     * @ORM\Column(type="date")
     */
    private $date;
    
    
    /**
     *
     * @ORM\Column(type="string")
     */
    private $mois;
    
    
    /**
     *
     * @ORM\Column(type="string")
     */
    private $annee;


    public function __construct() {
        $this->date = new \DateTime() ;
    }

            public function getId()
    {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

        public function getFicheDePaie() {
        return $this->ficheDePaie;
    }



    public function getSalarie() {
        return $this->salarie;
    }

    public function setFicheDePaie($ficheDePaie) {
        $this->ficheDePaie = $ficheDePaie;
        return $this;
    }


    public function setSalarie($salarie) {
        $this->salarie = $salarie;
        return $this;
    }
    public function getMois() {
        return $this->mois;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function setMois($mois) {
        $this->mois = $mois;
        return $this;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
        return $this;
    }




}