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
    *
    * @var type 
    */
    private $salarie_id;
    
    private $statut;
    
    private $date_debut;
    
    private $date_fin;
    
    private $nb_de_jour;
    private $salarie;
    
    
    
    


    public function getId()
    {
        return $this->id;
    }
}
