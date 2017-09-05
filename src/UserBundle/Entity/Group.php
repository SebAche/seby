<?php
namespace UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Group
 * @ORM\Table(name="app_group")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    protected $libelle;

    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles = array());

    }
    
   

    function getLibelle()
    {
        return $this->libelle;
    }

     function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }


    public function __toString()
    {
        return $this->libelle;
    }

}
