<?php

namespace WhackUp\ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use WhackUp\ManageBundle\Entity\ImageDisco;


/**
 * Disco
 *
 * @ORM\Table(name="disco")
 * @ORM\Entity(repositoryClass="WhackUp\ManageBundle\Repository\DiscoRepository")
 * @UniqueEntity(fields="nom", message="This Disco is already used ...")
 */
class Disco
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="You have to define name of night club")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\NotBlank(message="You have to define location of night club")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="complement", type="string", length=255)
     */
    private $complement;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255)
     */
    private $web;

    /**
     * @var string
     *
     * @ORM\Column(name="connexion", type="string", length=255)
     * @Assert\NotBlank(message="You have to define link of online connexion")
     */
    private $connexion;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\OneToOne(targetEntity="WhackUp\ManageBundle\Entity\ImageDisco", cascade={"persist"})
     */
    private $image;

    public function __construct()
    {
        $this->created = new \Datetime();
    }

    public function setImage(ImageDisco $image = null) //ImageDisco
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Disco
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Disco
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set complement
     *
     * @param string $complement
     *
     * @return Disco
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set web
     *
     * @param string $web
     *
     * @return Disco
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set connexion
     *
     * @param string $connexion
     *
     * @return Disco
     */
    public function setConnexion($connexion)
    {
        $this->connexion = $connexion;

        return $this;
    }

    /**
     * Get connexion
     *
     * @return string
     */
    public function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Disco
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Disco
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}

