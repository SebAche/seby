<?php

namespace MathBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Operateur
 *
 * @ExclusionPolicy("all")
 * @ORM\Table(name="math_operateur")
 * @ORM\Entity(repositoryClass="MathBundle\Repository\OperateurRepository")
 */
class Operateur
{
    const ADDITION = 1;
    const SOUSTRACTION = 2;
    const MULTIPLICATION = 3;
    const DIVISION = 4;

    /**
     * @var int
     *
     * @Expose
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="symbole", type="string", length=5, unique=true)
     */
    private $symbole;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Operateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set symbole
     *
     * @param string $symbole
     *
     * @return Operateur
     */
    public function setSymbole($symbole)
    {
        $this->symbole = $symbole;

        return $this;
    }

    /**
     * Get symbole
     *
     * @return string
     */
    public function getSymbole()
    {
        return $this->symbole;
    }

    public function __toString()
    {
        return $this->nom;
    }

}

