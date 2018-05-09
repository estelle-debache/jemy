<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *@ORM\Column(type="string", columnDefinition="enum('en cours', 'validé', 'refusé')", nullable=false)
     *
     */
    private $statut;
    
    /**
     *
     * @ORM\Column(type="date")
     */
    private $date_debut;
    
    /**
     *
     * @ORM\Column(type="date")
     */
    private $date_fin;
    /**
     *
     * @ORM\Column(type="integer", length=2)
     */
    private $nb_de_jour;
    
  /**
   *
    * @ORM\JoinColumn(nullable=false)
    * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="conge") 
   */  
    
    private $salarie;


    public function getId()
    {
        return $this->id;
    }
}