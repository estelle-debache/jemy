<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * 
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 * 
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     */
    private $id;
    
    /**
     *@Assert\NotBlank(message = "LE NOM EST OBLIGATOIRE")
     *@ORM\Column(type="string", length=30)
     */
    private $nom;
    
    /**
     *
     * @ORM\Column(type="string", length=9)
     */
    private $siren;
    
    /**
     *
     *@ORM\Column(type="string", length=14)
     */
    private $siret;
    
    /**
     *
     *@ORM\Column(type="string", columnDefinition="enum('SARL', 'SAS', 'SA' )", nullable=false)
     */
    private $formeJuridique;
    public function getFormeJuridique() {
        return $this->formeJuridique;
    }

    public function setFormeJuridique($formeJuridique) {
        $this->formeJuridique = $formeJuridique;
        return $this;
    }

        /**
     *
     *@ORM\Column(type="string", length=250)
     */
    private $adresse;
    
    /**
     *
     *@ORM\Column(type="string", length=5)
     */
    private $codePostal;
    
    /**
     *
     *@ORM\Column(type="string", length=20)
     */
    private $ville;

    /**
     *
     * @ORM\Column(type="string", length=10)
     */
    private $telephone;
    
    /**
     * @ORM\OneToMany(targetEntity="Salarie", mappedBy="entreprise", cascade={"persist"})
     */
    private $salarie;
    
    /**
     *
     *@ORM\OneToMany(targetEntity="Service", mappedBy="entreprise", cascade={"persist"})
     */
    private $service;



        
    
    /**
     *
     * @ORM\OneToMany(targetEntity="OffreEmploi", mappedBy="entreprise")
     */
    private $OffreEmploi;
    
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getSiren() {
        return $this->siren;
    }

    public function getSiret() {
        return $this->siret;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getCodePostal() {
        return $this->codePostal;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getSalarie() {
        return $this->salarie;
    }

    public function getService() {
        return $this->service;
    }

    public function getOffreEmploi() {
        return $this->OffreEmploi;
    }



    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setSiren($siren) {
        $this->siren = $siren;
        return $this;
    }

    public function setSiret($siret) {
        $this->siret = $siret;
        return $this;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    public function setSalarie($salarie) {
        $this->salarie = $salarie;
        return $this;
    }

    public function setService($service) {
        $this->service = $service;
        return $this;
    }

    public function setOffreEmploi($OffreEmploi) {
        $this->OffreEmploi = $OffreEmploi;
        return $this;
    }


    

}
