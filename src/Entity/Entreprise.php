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
     * @Assert\NotBlank(message="Merci de renseigner le nom de votre société")
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Le nom doit contenir {{ limit }} caractères minimum",
     *      maxMessage = "Le nom ne doit pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=30)
     */
    private $nom;
    
    /**
     * @Assert\NotBlank(message="Merci de renseigner le SIREN")
     * @Assert\Length(
     *      min = 9,
     *      max = 9,
     *      minMessage = "Le Siren doit contenir {{ limit }} chiffres minimum",
     *      maxMessage = "Le Siren ne doit pas contenir plus de {{ limit }} chiffres "
     * )
     * @ORM\Column(type="string", length=9)
     */
    private $siren;
    
    /**
     * @Assert\NotBlank(message="Merci de renseigner le SIRET")
     * @Assert\Length(
     *      min = 14,
     *      max = 14,
     *      minMessage = "Le Siret doit contenir {{ limit }} chiffres minimum",
     *      maxMessage = "Le Siret ne doit pas contenir plus de {{ limit }} chiffres "
     * )
     * @ORM\Column(type="string", length=14)
     */
    private $siret;
    
    /**
     * @Assert\NotBlank(message="Merci de renseigner la forme juridique de votre société")
     * @ORM\Column(type="string", columnDefinition="enum('SARL', 'SAS', 'SA' )", nullable=false)
     */
    private $formeJuridique;
    
     /**
     * @Assert\NotBlank(message="Merci de renseigner une adresse")
     * @Assert\Length(
     *      min = 5,
     *      max = 250,
     *      minMessage = "L'adresse doit contenir {{ limit }} caractères minimum",
     *      maxMessage = "L'adresse ne doit pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=250)
     */
    private $adresse;
    
    /**
     * @Assert\NotBlank(message ="Merci de renseigner le code postal")
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Le code postal doit contenir {{ limit }} chiffres minimum",
     *      maxMessage = "Le code postal ne doit pas dépasser {{ limit }} chiffres"
     * )
     * @ORM\Column(type="integer", length=5)
     */
    private $codePostal;
    
    /**
     * @Assert\NotBlank(message="Merci de renseigner la ville")
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "La ville doit contenir {{ limit }} caractères minimum",
     *      maxMessage = "La ville ne doit pas dépasser {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=20)
     */
    private $ville;

    /**
     * @Assert\NotBlank(message="Merci de renseigner le numéro de téléphone")
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
     * @ORM\OneToMany(targetEntity="Service", mappedBy="entreprise", cascade={"persist"})
     */
    private $services;

    /**
     *
     *  @ORM\OneToMany(targetEntity="Candidature", mappedBy="entreprise")
     */
    private $candidatures;    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="OffreEmploi", mappedBy="entreprise")
     */
    private $OffreEmploi;
    
    
    
    /**
     *
     *@ORM\Column(type="float", nullable=true) 
     */
    private $nbcpgagne;
    
    
    /**
     *
     * @ORM\Column(type="float", nullable= true)
     */
    private $nbrttgagne;
    
    /**
     *
     * @ORM\Column(type="string", length=255, nullable= true)
     */
    private $logo;
    
    
    public function getLogo() {
        return $this->logo;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
        return $this;
    }

        public function getCandidatures() {
        return $this->candidatures;
    }

    public function getNbcpgagne() {
        return $this->nbcpgagne;
    }

    public function getNbrttgagne() {
        return $this->nbrttgagne;
    }

    public function setCandidatures($candidatures) {
        $this->candidatures = $candidatures;
        return $this;
    }

    public function setNbcpgagne($nbcpgagne) {
        $this->nbcpgagne = $nbcpgagne;
        return $this;
    }

    public function setNbrttgagne($nbrttgagne) {
        $this->nbrttgagne = $nbrttgagne;
        return $this;
    }

        public function __construct() {
        $this->OffreEmploi = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->salaries = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
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
    
    public function getFormeJuridique() {
        return $this->formeJuridique;
    }

    public function setFormeJuridique($formeJuridique) {
        $this->formeJuridique = $formeJuridique;
        return $this;
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

    public function getServices() {
        return $this->services;
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

    public function setServices($services) {
        $this->services = $services;
        return $this;
    }
    
    public function addService(Service $services)
    {
        $this->services->add($services);
        $services->setEntreprise($this);
    }

    public function setOffreEmploi($OffreEmploi) {
        $this->OffreEmploi = $OffreEmploi;
        return $this;
    }
    
    public function countBySalarie() {
        return count($this->salaries);
        
    }


    

}
