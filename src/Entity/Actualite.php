<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    
    
    /**
     * @Assert\NotBlank(message="Merci de mettre un titre")
     * @Assert\Length (
     *      min = 2,
     *      minMessage = "Le titre doit contenir {{ limit }} caractères minimum",
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $titre;
    

    
    /**
     * @Assert\NotBlank(message="Merci de mettre un contenue")
     * @Assert\Length (
     *      min = 5,
     *      minMessage = "Le titre doit contenir {{ limit }} caractères minimum",
     * )
     * @ORM\Column(type="text")
     */
    private $contenu;
    /**
     *@Assert\NotBlank(message="LA DATE DE PUBLICATION EST OBLIGATOIRE")
     * @var \Datetime
     * @ORM\Column(type="date")
     */
    private $date;
    
    
    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Salarie", inversedBy="actualite") 
     */
    private $salarie;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Image()
     * @var string
     */
    private $image;
    
    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

        
    public function getTitre() {
        return $this->titre;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getDate() {
        return $this->date;
    }

    public function getSalarie() {
        return $this->salarie;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
        return $this;
    }

    public function setDate(\Datetime $date) {
        $this->date = $date;
        return $this;
    }

    public function setSalarie($salarie) {
        $this->salarie = $salarie;
        return $this;
    }

        
    public function getId()
    {
        return $this->id;
    }
    
    public function __construct() {
        $this->date = new DateTime();
    }

}
