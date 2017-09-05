<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * @author Sébastien
 */
class Contact
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable=false)
    * 
    */
    private $nom;

    /**
    * @ORM\Column(type="string", length=255, nullable=false)
    * 
    */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=60, unique=true, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(name="date_naissance", type="datetime", nullable=true)
     */
    private $dateNaissance;

//    /**
//     * @var integer
//     *
//     * @ORM\ManyToOne(targetEntity="Group", inversedBy="contacts")
//     */
//    private $groupe;
    
    public function getId()
    {
        return $this->id;
    }

        public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
    }

    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }


}
