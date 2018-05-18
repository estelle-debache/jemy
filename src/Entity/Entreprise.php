<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 * @UniqueEntity(fields="siret",
 *   message="Il existe déja une entreprise avec cet siret ")
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
     *@Assert\NotBlank(message="LE NOM EST OBLIGATOIRE")
     *@ORM\Column(type="string", length=30)
     */
    private $nom;
    
    /**
     *@Assert\NotBlank(message="LE SIREN EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=9)
     */
    private $siren;
    
    /**
     *@Assert\NotBlank(message="LE SIRET EST OBLIGATOIRE")
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
     *@Assert\NotBlank(message="L'ADRESSE EST OBLIGATOIRE")
     *@ORM\Column(type="string", length=250)
     */
    private $adresse;
    
    /**
     *@Assert\NotBlank(message="LE CODE POSTAL EST OBLIGATOIRE")
     *@ORM\Column(type="string", length=5)
     */
    private $codePostal;
    
    /**
     *@Assert\NotBlank(message="LA VILLE EST OBLIGATOIRE")
     *@ORM\Column(type="string", length=20)
     */
    private $ville;

    /**
     *@Assert\NotBlank(message="LE NUMERO TELEPHONE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=10)
     */
    private $telephone;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Salarie", mappedBy="entreprise", cascade={"persist"})
     */
    private $salaries;
    
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
    
    public function __construct() {
        $this->OffreEmploi = new ArrayCollection();
        $this->service = new ArrayCollection();
        $this->salaries = new ArrayCollection();
    }

    
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

    public function getSalaries() {
        return $this->salaries;
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

    public function setSalaries($salaries) {
        $this->salaries = $salaries;
        return $this;
    }

    public function setService($service) {
        $this->service = $service;
        return $this;
    }
    
    public function addService(Service $service)
    {
        $this->service->add($service);
        $service->setEntreprise($this);
    }

    public function setOffreEmploi($OffreEmploi) {
        $this->OffreEmploi = $OffreEmploi;
        return $this;
    }


    

}
