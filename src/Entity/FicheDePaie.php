<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheDePaieRepository")
 */
class FicheDePaie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    private $salarie_id;
    
    private $date_emission;
    
    private $mois;
    
    private $fiche_de_paie;

    public function getId()
    {
        return $this->id;
    }
}
