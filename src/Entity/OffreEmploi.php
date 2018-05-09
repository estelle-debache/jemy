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
    
    private $entreprise_id;
    
    private $poste;
    
    private $contrat;
    
    private $description;
    
    private $date_publication;
    
    private $service_id;
    
    private $salaire;
    
    
    

    public function getId()
    {
        return $this->id;
    }
}
