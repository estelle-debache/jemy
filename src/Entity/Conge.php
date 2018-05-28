<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CongeRepository")
 */
class Conge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    
    
    
      /**
     *@Assert\NotBlank(message="LE STATUS EST OBLIGATOIRE") 
     *@ORM\Column(type="string", columnDefinition="enum('En cours', 'validé', 'refusé')", nullable=true)
     *
     */
    private $statut;
    
    /**
     *@Assert\NotBlank(message="LA DATE DE DEBUT EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $datedebut;
    
    /**
     *@Assert\NotBlank(message="LA DATE DE FIN EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $datefin;
    /**
     *@Assert\NotBlank(message="LE NOMBRE DE JOUR EST OBLIGATOIRE")
     * @ORM\Column(type="integer", length=2)
     */
    private $nbdejour;
    
  /**
   *
    * @ORM\JoinColumn(nullable=false)
    * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="conge") 
   */  
    
    private $salarie;

   /**
    *
    * @ORM\Column(type="text", nullable=true)
    */
    private $comment;
    
      /**
     *@Assert\NotBlank(message="LE type de congé est obligatoire") 
     *@ORM\Column(type="string", columnDefinition="enum('RTT', 'Congé payé')")
     *
     */
    private $typeconge;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getStatut() {
        return $this->statut;
    }

    public function getDatedebut() {
        return $this->datedebut;
    }

    public function getDatefin() {
        return $this->datefin;
    }

    public function getNbdejour() {
        return $this->nbdejour;
    }

    public function getSalarie() {
        return $this->salarie;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getTypeconge() {
        return $this->typeconge;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    public function setDatedebut($datedebut) {
        $this->datedebut = $datedebut;
        return $this;
    }

    public function setDatefin($datefin) {
        $this->datefin = $datefin;
        return $this;
    }

    public function setNbdejour($nbdejour) {
        $this->nbdejour = $nbdejour;
        return $this;
    }

    public function setSalarie($salarie) {
        $this->salarie = $salarie;
        return $this;
    }

    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }

    public function setTypeconge($typeconge) {
        $this->typeconge = $typeconge;
        return $this;
    }



}