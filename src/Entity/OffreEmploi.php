<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreEmploiRepository")
 * 
 */
class OffreEmploi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="LE POSTE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $poste;

    /**
     *@Assert\NotBlank(message="LE CONTRAT EST OBLIGATOIRE")
     * @ORM\Column(type="string", columnDefinition="enum('CDD', 'CDI')", nullable=false)
    */
    private $contrat;

    /**
     * @Assert\NotBlank(message="LA DESCRIPTION EST OBLIGATOIRE")
     * @ORM\Column(type="text")
     */
        private $description;

    /**
     *
     * @var \Datetime
     * @ORM\Column(type="date")
     * 
     */
    private $datePublication;
        /**
     *
     * @ORM\Column(type="integer")
     */
    private $salaire;

      /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="OffreEmploi")
     */
    private $service;


    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="OffreEmploi")
     */
    private $entreprise;

    public function getId()
    {
        return $this->id;
    }
    public function getPoste() {
        return $this->poste;
    }

    public function getContrat() {
        return $this->contrat;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDatePublication() {
        return $this->datePublication;
    }

    public function getSalaire() {
        return $this->salaire;
    }

    public function getService() {
        return $this->service;
    }

    public function getEntreprise() {
        return $this->entreprise;
    }

    public function setPoste($poste) {
        $this->poste = $poste;
        return $this;
    }

    public function setContrat($contrat) {
        $this->contrat = $contrat;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setDatePublication($datePublication) {
        $this->datePublication = $datePublication;
        return $this;
    }

    public function setSalaire($salaire) {
        $this->salaire = $salaire;
        return $this;
    }

    public function setService($service) {
        $this->service = $service;
        return $this;
    }

    public function setEntreprise($entreprise) {
        $this->entreprise = $entreprise;
        return $this;
    }

     public function __construct() {
        $this->datePublication = new DateTime();
    }

}