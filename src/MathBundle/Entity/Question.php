<?php

namespace MathBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Question
 *
 * @ExclusionPolicy("all")
 * @ORM\Table(name="math_question")
 * @ORM\Entity(repositoryClass="MathBundle\Repository\QuestionRepository")
 */
class Question
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
     *
     * @ORM\ManyToOne(targetEntity="MathBundle\Entity\Partie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @var int
     *
     * @ORM\Column(name="operande1", type="integer")
     */
    private $operande1;

    /**
     * @var int
     *
     * @ORM\Column(name="operande2", type="integer")
     */
    private $operande2;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MathBundle\Entity\Operateur")
     */
    private $operateur;

    /**
     * @var foat
     *
     * @ORM\Column(name="resultatCorrect", type="float")
     */
    private $resultatCorrect;

    /**
     * @var float
     *
     * @ORM\Column(name="resultatDonne", type="float", nullable = true)
     */
    private $resultatDonne;

    /**
     * @var bool
     *
     * @ORM\Column(name="isCorrect", type="boolean", nullable = true)
     */
    private $isCorrect;

    /**
     * @var float
     *
     * @ORM\Column(name="tempsPasse", type="float", nullable = true)
     */
    private $tempsPasse;


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
     * Set partie
     *
     *
     * @return Question
     */
    public function setPartie(Partie $partie)
    {
        $this->partie = $partie;

        return $this;
    }

    /**
     * Get partie
     *
     */
    public function getPartie()
    {
        return $this->partie;
    }

    /**
     * Set operande1
     *
     * @param integer $operande1
     *
     * @return Question
     */
    public function setOperande1($operande1)
    {
        $this->operande1 = $operande1;

        return $this;
    }

    /**
     * Get operande1
     *
     * @return int
     */
    public function getOperande1()
    {
        return $this->operande1;
    }

    /**
     * Set operande2
     *
     * @param integer $operande2
     *
     * @return Question
     */
    public function setOperande2($operande2)
    {
        $this->operande2 = $operande2;

        return $this;
    }

    /**
     * Get operande2
     *
     * @return int
     */
    public function getOperande2()
    {
        return $this->operande2;
    }

    public function getOperateur()
    {
        return $this->operateur;
    }

    public function setOperateur(Operateur $operateur)
    {
        $this->operateur = $operateur;
        return $this;
    }

    
    /**
     * Set resultatCorrect
     *
     * @param float $resultatCorrect
     *
     * @return Question
     */
    public function setResultatCorrect($resultatCorrect)
    {
        $this->resultatCorrect = $resultatCorrect;

        return $this;
    }

    /**
     * Get resultatCorrect
     *
     * @return float
     */
    public function getResultatCorrect()
    {
        return $this->resultatCorrect;
    }

    /**
     * Set resultatDonne
     *
     * @param float $resultatDonne
     *
     * @return Question
     */
    public function setResultatDonne($resultatDonne)
    {
        $this->resultatDonne = $resultatDonne;

        return $this;
    }

    /**
     * Get resultatDonne
     *
     * @return float
     */
    public function getResultatDonne()
    {
        return $this->resultatDonne;
    }

    /**
     * Set isCorrect
     *
     * @param boolean $isCorrect
     *
     * @return Question
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return bool
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * Set tempsPasse
     *
     * @param float $tempsPasse
     *
     * @return Question
     */
    public function setTempsPasse($tempsPasse)
    {
        $this->tempsPasse = $tempsPasse;

        return $this;
    }

    /**
     * Get tempsPasse
     *
     * @return float
     */
    public function getTempsPasse()
    {
        return $this->tempsPasse;
    }
}

