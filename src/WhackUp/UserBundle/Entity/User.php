<?php

namespace WhackUp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\Common\Collections\ArrayCollection;
use WhackUp\ManageBundle\Entity\Disco;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WhackUp\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="username", message="this login already used ...")
 */
class User extends BaseUser
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
     * @ORM\OneToOne(targetEntity="WhackUp\UserBundle\Entity\Image", cascade={"persist"})
     */

    protected $image;

    /**
     * @ORM\ManyToMany(targetEntity="WhackUp\ManageBundle\Entity\Disco", cascade={"persist"})
     */
    private $discos;

    public function __construct(){
        parent::__construct();
        $this->discos = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     * get list of favoris (disco)
     */
    public function getDiscos()
    {
        return $this->discos;
    }

    /**
     * @param Disco $disco
     * @return $this
     * add disco like favoris
     */
    public function addDisco(Disco $disco)
    {
        $this->discos[] = $disco;
        return $this;
    }

    /**
     * @param Disco $disco
     * remove disco like favoris
     */
    public function removeDisco(Disco $disco)
    {
       $this->discos->removeElement($disco);
    }

    public function setImage(Image $image = null)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }


}
