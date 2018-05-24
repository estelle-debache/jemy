<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatureRepository")
 */
class Candidature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cv;

    /**
     * @ORM\Column(type="text")
     */
    private $motivation;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCandidature;

    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="OffreEmploi", inversedBy="candidatures")
     */
    private $offreEmploi;
    
    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="candidatures")
     */
    private $entreprise;
    public function getEntreprise() {
        return $this->entreprise;
    }

    public function setEntreprise($entreprise) {
        $this->entreprise = $entreprise;
        return $this;
    }

        /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="candidature")
     */
    private $salarie;
    
        public function __construct()
    {
        $this->dateCandidature = new \DateTime();
    }
    
    public function getSalarie() {
        return $this->salarie;
    }

    public function setSalarie($salarie) {
        $this->salarie = $salarie;
        return $this;
    }

        public function getId()
    {
        return $this->id;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv( $cv)
    {
        $this->cv = $cv;

        return $this;
    }

    public function getMotivation()
    {
        return $this->motivation;
    }

    public function setMotivation( $motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getDateCandidature()
    {
        return $this->dateCandidature;
    }

    public function setDateCandidature(\DateTimeInterface $dateCandidature)
    {
        $this->dateCandidature = $dateCandidature;

        return $this;
    }

    public function getOffreEmploi()
    {
        return $this->offreEmploi;
    }

    public function setOffreEmploi( $offreEmploi)
    {
        $this->offreEmploi = $offreEmploi;

        return $this;
    }
}
