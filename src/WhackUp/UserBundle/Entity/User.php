<?php

namespace WhackUp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

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

    public function setImage(Image $image = null)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }


}
