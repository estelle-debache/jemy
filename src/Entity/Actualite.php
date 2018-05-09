<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActualiteRepository")
 */
class Actualite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    private $titre;
    
    private $auteur_id;
    
    private $contenu;
    
    private $date;

    public function getId()
    {
        return $this->id;
    }
}
