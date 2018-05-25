<?php

namespace App\Entity;

use App\Entity\Entreprise;
use App\Entity\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields="email", message="Il existe deja un compte salarié avec cet email")
 * @ORM\Entity(repositoryClass="App\Repository\SalarieRepository")
 */
class Salarie implements UserInterface, Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * cle etrangere vers entreprise
     * inversedby doit etre ajoute quand on a ajoute un onetomany dans la classe user sur l'attribut publications
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="salaries")
     * @var Entreprise 
     */
    private $entreprise;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin"}, message = "LE NOM EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=20)
     */
    private $nom;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin"}, message = "LE PRENOM EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin"}, message = "L'EMAIL EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255, unique=true) 
     */
    private $email;
    
    /**
     *
     * @ORM\Column(type="string", columnDefinition="enum('Mr', 'Mme')", nullable=false)
     */
    private $civilite;
    
    /**
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $password;

 


    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin"}, message = "LA DATE DE NAISSANCE EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $dateDeNaissance;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin", "edition"}, message = "L'ADRESSE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin", "edition"}, message = "LE CODE POSTAL EST OBLIGATOIRE")
     * @ORM\Column(type="integer", length=5)
     */
    private $codePostal;
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin", "edition"}, message = "LA VILLE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=255)
     */
    private $ville;
    
    /**
     *@Assert\NotBlank(groups={"inscription-admin", "edition-admin"}, message = "LA DATE d'EMBAUCHE EST OBLIGATOIRE")
     * @ORM\Column(type="date")
     */
    private $dateEmbauche;
    
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin"}, message = "LE NUMERO DE SECURITE SOCIALE EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=15)
     */
    private $numSs;
    
    /**
     *
     * @ORM\Column(type="string", columnDefinition="enum('ROLE_USER', 'ROLE_ADMIN')", nullable=false)
     */
    private $role;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin", "edition-admin", "edition"}, message = "LE RIB EST OBLIGATOIRE")
     * @ORM\Column(type="string", length=27)
     */
    private $iban;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin"}, message = "LA PIECE D'IDENTITE EST OBLIGATOIRE")
     * @Assert\Image(groups={"inscription-admin", "edition-admin"})
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $carteIdentite;
    
    /**
     * @Assert\NotBlank(groups={"inscription-admin"}, message = "LE CONTRAT DU TRAVAIL EST OBLIGATOIRE")
     * @Assert\File(groups={"inscription-admin", "edition-admin"}, mimeTypes={"application/pdf"})
     * @ORM\Column(type="string", length=255)
     */
    private $contratTravail;
    /**
     * @Assert\Image(groups={"inscription-admin", "edition-admin", "edition"}, )
     * @ORM\Column(type="string", length=255)
     */
    private $photo;
    
    /**
     *
     * @ORM\Column(type="integer", length=2, nullable=true) 
     */
    private $soldeConge;
    
    /**
     *
     * @ORM\Column(type="string", columnDefinition="enum('en activite', 'fin de contrat')", nullable=true)
     */
    private $statut;
    /**
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFinContrat; 
    
       

    
    
    /**
     *
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="salarie")
     */
    private $service;

    /**
     *
     * @ORM\OneToMany(targetEntity="FicheDePaie", mappedBy="salarie")
     */
    private $FicheDePaies;
    
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Actualite", mappedBy="salarie") 
     */
    private $actualite;
    /**
     *
     * @ORM\OneToMany(targetEntity="Conge", mappedBy="salarie")
     */
    private $conge;
    
    /**
     *Mot de passe en clair pourinteragir avec le formulaire 
     * va recuperer le mot de passe en clair dans l'interaction avec le formulaire
     * @Assert\NotBlank(groups={"inscription-admin"}, message="vous devez imperativement remplir le champs mot de passe")
    */
    private $plainPassword;
    
    /**
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $telephone;  
    /**
     *
     *@ORM\OneToMany(targetEntity="Candidature", mappedBy="salarie") 
     */
    private $candidature;
    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

        public function getId() {
        return $this->id;
    }

    public function getEntreprise() {
        return $this->entreprise;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCivilite() {
        return $this->civilite;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDateDeNaissance() {
        return $this->dateDeNaissance;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getCodePostal() {
        return $this->codePostal;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getDateEmbauche() {
        return $this->dateEmbauche;
    }

    public function getNumSs() {
        return $this->numSs;
    }

    public function getRole() {
        return $this->role;
    }

    public function getIban() {
        return $this->iban;
    }

    public function getCarteIdentite() {
        return $this->carteIdentite;
    }

    public function getContratTravail() {
        return $this->contratTravail;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getSoldeConge() {
        return $this->soldeConge;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getDateFinContrat() {
        return $this->dateFinContrat;
    }

    public function getService() {
        return $this->service;
    }

    public function getFicheDePaies() {
        return $this->FicheDePaies;
    }

    public function getActualite() {
        return $this->actualite;
    }

    public function getConge() {
        return $this->conge;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setEntreprise(Entreprise $entreprise) {
        $this->entreprise = $entreprise;
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

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setCivilite($civilite) {
        $this->civilite = $civilite;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setDateDeNaissance($dateDeNaissance) {
        $this->dateDeNaissance = $dateDeNaissance;
        return $this;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function setDateEmbauche($dateEmbauche) {
        $this->dateEmbauche = $dateEmbauche;
        return $this;
    }

    public function setNumSs($numSs) {
        $this->numSs = $numSs;
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

    public function setCarteIdentite($carteIdentite) {
        $this->carteIdentite = $carteIdentite;
        return $this;
    }

    public function setContratTravail($contratTravail) {
        $this->contratTravail = $contratTravail;
        return $this;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    public function setSoldeConge($soldeConge) {
        $this->soldeConge = $soldeConge;
        return $this;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    public function setDateFinContrat($dateFinContrat) {
        $this->dateFinContrat = $dateFinContrat;
        return $this;
    }

    public function setService($service) {
        $this->service = $service;
        return $this;
    }

    public function setFicheDePaies($FicheDePaies) {
        $this->FicheDePaies = $FicheDePaies;
        return $this;
    }

    public function setActualite($actualite) {
        $this->actualite = $actualite;
        return $this;
    }

    public function setConge($conge) {
        $this->conge = $conge;
        return $this;
    }

    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
        return $this;
    }
    public function serialize() {
           return serialize(             [
                    $this->id,
                    $this->nom,
                    $this->prenom,
                    $this->email,
                    $this->password
                  ]
                );
        
    }

      public function unserialize( $serialized) {
        list(
                    $this->id,
                    $this->nom,
                    $this->prenom,
                    $this->email,
                    $this->password
                ) = unserialize($serialized)
                ;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
         return [$this->role];
    }

    public function getSalt() {
        return null;
        
    }

    public function getUsername() {
        return $this->email;
    }
    public function getFullName()
    {
        return trim($this->prenom.' ' . $this->nom);
    }
    public function __toString() {
        return $this->getFullName();
        
    }
    public function __construct() {
        $this->FicheDePaies = new ArrayCollection();
    }






}
