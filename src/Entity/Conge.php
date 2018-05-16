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
     *@ORM\Column(type="string", columnDefinition="enum('en cours', 'validé', 'refusé')", nullable=false)
     *
     */
    private $statut;
    
    /**
     *@Assert\NotBlank(message="LA DATE DE DEBUT EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $date_debut;
    
    /**
     *@Assert\NotBlank(message="LA DATE DE FIN EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $date_fin;
    /**
     *@Assert\NotBlank(message="LE NOMBRE DE JOUR EST OBLIGATOIRE")
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