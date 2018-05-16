<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreEmploiRepository")
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
     * @Assert\NotBlank(message = "LE POSTE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $poste;
    
    /**
     * @Assert\NotBlank(message = "LE CONTRAT EST OBLIGATOIRE")
     *@ORM\Column(type="string", columnDefinition="enum('cdd', 'cdi')", nullable=false)
    */
    private $contrat;
    
    /**
     * @Assert\NotBlank(message = "LA DESCRIPTION EST OBLIGATOIRE")
     * @ORM\Column(type="text")
     */
        private $description;
    
    /**
     * @Assert\NotBlank(message = "LA DATE DE PUBLICATION EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $date_publication;
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
}