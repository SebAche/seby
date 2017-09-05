<?php

namespace MathBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Partie
 *
 * @ExclusionPolicy("all")
 * @ORM\Table(name="math_partie")
 * @ORM\Entity(repositoryClass="MathBundle\Repository\PartieRepository")
 */
class Partie
{
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
     * @ORM\ManyToOne(targetEntity="MathBundle\Entity\Joueur" )
     * @ORM\JoinColumn(nullable=false)
     */
    private $joueur;

    /**
     * @var int
     *
     * @ORM\Column(name="TempsParQuestions", type="integer")
     */
    private $tempsParQuestion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="score", type="string", length=255, nullable=true)
     */
    private $score = 0;

    /**
     * @ORM\ManyToMany(targetEntity="MathBundle\Entity\Operateur")
     * @var type
     */
    private $operateurs;

    /**
     * @var int
     *
     * @ORM\Column(name="operande_max", type="integer")
     */
    private $operandeMax;

    /**
     * @var int
     *
     * @ORM\Column(name="operande_min", type="integer")
     */
    private $operandeMin;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite_question", type="integer")
     */
    private $quantiteQuestion;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

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
     * Set joueur
     *
     *
     * @return Partie
     */
    public function setJoueur(Joueur $joueur)
    {
        $this->joueur = $joueur;

        return $this;
    }

    /**
     * Get joueur
     *
     */
    public function getJoueur()
    {
        return $this->joueur;
    }

    /**
     * Set tempsParQuestion
     *
     * @param integer $tempsParQuestion
     *
     * @return Partie
     */
    public function setTempsParQuestion($tempsParQuestion)
    {
        $this->tempsParQuestion = $tempsParQuestion;

        return $this;
    }

    /**
     * Get tempsParQuestion
     *
     * @return int
     */
    public function getTempsParQuestion()
    {
        return $this->tempsParQuestion;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Partie
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set score
     *
     * @param string $score
     *
     * @return Partie
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    public function getOperateurs()
    {
        return $this->operateurs;
    }

    public function setOperateurs($operateurs)
    {
        $this->operateurs = $operateurs;
        return $this;
    }

    public function getOperandeMax()
    {
        return $this->operandeMax;
    }

    public function getOperandeMin()
    {
        return $this->operandeMin;
    }

    public function setOperandeMax($operandeMax)
    {
        $this->operandeMax = $operandeMax;
        return $this;
    }

    public function setOperandeMin($operandeMin)
    {
        $this->operandeMin = $operandeMin;
        return $this;
    }

    public function getQuantiteQuestion()
    {
        return $this->quantiteQuestion;
    }

    public function setQuantiteQuestion($quantiteQuestion)
    {
        $this->quantiteQuestion = $quantiteQuestion;
        return $this;
    }



}

