<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     *
     *@ORM\Column(type="string", length=30)
     */
    private $nom;
    
    /**
     *
     * @ORM\Column(type="integer", length=9, unique=true)
     */
    private $siren;
    
    /**
     *
     *@ORM\Column(type="integer", length=20, unique=true)
     */
    private $siret;
    
    /**
     *
     *@ORM\Column(type="string", length=50)
     */
    private $forme_juridique;
    
    /**
     *
     *@ORM\Column(type="string", length=250)
     */
    private $adresse;
    
    /**
     *
     *@ORM\Column(type="integer", length=5)
     */
    private $code_postal;
    
    /**
     *
     *@ORM\Column(type="string", length=20)
     */
    private $ville;


    public function getNom() {
        return $this->nom;
    }

    public function getSiren() {
        return $this->siren;
    }

    public function getSiret() {
        return $this->siret;
    }

    public function getForme_juridique() {
        return $this->forme_juridique;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getCode_postal() {
        return $this->code_postal;
    }

    public function getVille() {
        return $this->ville;
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

    public function setForme_juridique($forme_juridique) {
        $this->forme_juridique = $forme_juridique;
        return $this;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    public function setCode_postal($code_postal) {
        $this->code_postal = $code_postal;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

        public function getId()
    {
        return $this->id;
    }
}
