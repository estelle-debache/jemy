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
    /*
     * @ORM\Column(type="date")
     */
    private $date_emission;
    /**
     *
     * @ORM\Column(type="string", length=20)
     */
    private $mois;
    
    /**
     *
     * @ORM\Column(type="string", length=255
     */
    private $fiche_de_paie;

    public function getId()
    {
        return $this->id;
    }
}
