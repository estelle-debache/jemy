<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecuperationRepository")
 */
class Recuperation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Salarie", inversedBy="recuperation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $salarie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $uniq;

    public function getId()
    {
        return $this->id;
    }

    public function getSalarie()
    {
        return $this->salarie;
    }

    public function setSalarie(Salarie $salarie)
    {
        $this->salarie = $salarie;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail( $email)
    {
        $this->email = $email;

        return $this;
    }
    public function getUniq() {
        return $this->uniq;
    }

    public function setUniq($uniq) {
        $this->uniq = $uniq;
        return $this;
    }


}
