<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalarieRepository")
 */
class Salarie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(type="string", length=255, unique=true) 
     */
    private $mail;
    
    /**
     *
     * @ORM\Column(type="string", columnDefinition="enum('Mr', 'Mme')", nullable=false)
     */
    private $civilite;
    

    
    /**
     *
     * @ORM\Column(type="string", length=20)
     */
    private $nom;
    
    /**
     *
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;
    /**
     *
     * @ORM\Column(type="date")
     */
    private $date_de_naissance;
    
    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;
    /**
     *
     * @ORM\Column(type="integer", length=5)
     */
    private $code_postale;
    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $ville;
    
    /**
     *
     * @ORM\Column(type="date")
     */
    private $date_embauche;
    
    
    /**
     *
     * @ORM\Column(type="string", length=15)
     */
    private $num_ss;
    
    /**
     *
     * @ORM\Column(type="string", columnDefinition="enum('fdp', 'admin')", nullable=false)
     */
    private $role;
    
    /**
     *
     * @ORM\Column(type="string", length=27)
     */
    private $iban;
    
    /**
     *@ORM\Column(type="string", length=255)
     * 
     */
    private $carte_identite;
    
    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $contrat_travail;
    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $photo;
    
    /**
     *
     * @ORM\Column(type="integer", length=2) 
     */
    private $solde_conge;
    
    /**
     *
     * @ORM\Column(type="string", columnDefinition="enum('en activite', 'fin de contrat')", nullable=false)
     */
    private $statut;
    /**
     *
     * @ORM\Column(type="date")
     */
    private $date_fin_contrat; 
    
       
    /**
     * cle etrangere vers entreprise
     * inversedby doit etre ajoute quand on a ajoute un onetomany dans la classe user sur l'attribut publications
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="salarie") 
     */
    private $entreprise;
    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="salarie") 
     */
    private $service;

    /**
     *
     * @ORM\OneToMany(targetEntity="FicheDePaie", mappedBy="salarie")
     */
    private $FicheDePaie;
    
    public function getId()
    {
        return $this->id;
    }
    public function getMail() {
        return $this->mail;
    }

    public function getCivilite() {
        return $this->civilite;
    }

    public function getEntreprise_id() {
        return $this->entreprise_id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getService_id() {
        return $this->service_id;
    }

    public function getDate_de_naissance() {
        return $this->date_de_naissance;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getCode_postale() {
        return $this->code_postale;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getDate_embauche() {
        return $this->date_embauche;
    }

    public function getNum_ss() {
        return $this->num_ss;
    }

    public function getRole() {
        return $this->role;
    }

    public function getIban() {
        return $this->iban;
    }

    public function getCarte_identite() {
        return $this->carte_identite;
    }

    public function getContrat_travail() {
        return $this->contrat_travail;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getSolde_conge() {
        return $this->solde_conge;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getDate_fin_contrat() {
        return $this->date_fin_contrat;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }

    public function setCivilite($civilite) {
        $this->civilite = $civilite;
        return $this;
    }

    public function setEntreprise_id($entreprise_id) {
        $this->entreprise_id = $entreprise_id;
        return $this;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    public function setService_id($service_id) {
        $this->service_id = $service_id;
        return $this;
    }

    public function setDate_de_naissance($date_de_naissance) {
        $this->date_de_naissance = $date_de_naissance;
        return $this;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    public function setCode_postale($code_postale) {
        $this->code_postale = $code_postale;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function setDate_embauche($date_embauche) {
        $this->date_embauche = $date_embauche;
        return $this;
    }

    public function setNum_ss($num_ss) {
        $this->num_ss = $num_ss;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function setIban($iban) {
        $this->iban = $iban;
        return $this;
    }

    public function setCarte_identite($carte_identite) {
        $this->carte_identite = $carte_identite;
        return $this;
    }

    public function setContrat_travail($contrat_travail) {
        $this->contrat_travail = $contrat_travail;
        return $this;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    public function setSolde_conge($solde_conge) {
        $this->solde_conge = $solde_conge;
        return $this;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    public function setDate_fin_contrat($date_fin_contrat) {
        $this->date_fin_contrat = $date_fin_contrat;
        return $this;
    }


}
