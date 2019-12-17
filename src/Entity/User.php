<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user", indexes={
 *         @ORM\Index(name="idx_user_identifier", columns={"user_identifier"})
 *     })
 */
class User extends BaseUser
{
    const USER_IDENTIFIER_LENGTH = 20;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type(name="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_identifier", type="string", length=255, unique=true, nullable=false)
     * @JMS\Type(name="string")
     * @JMS\Groups({"api"})
     * @JMS\SerializedName("_uid")
     */
    protected $userIdentifier;

    /**
     * {@inheritdoc}
     *
     * @JMS\Type(name="string")
     * @JMS\Groups({"api"})
     */
    protected $username;

    /**
     * {@inheritdoc}
     *
     * @JMS\Type(name="string")
     * @JMS\Groups({"api"})
     */
    protected $email;


    /**
     * @var ArrayCollection<Ingredient>
     *
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @JMS\Groups({"api"})
     */
    protected $favoriteIngredients;

    public function __construct()
    {
        parent::__construct();

        $this->favoriteIngredients = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @param string $userIdentifier
     *
     * @return User
     */
    public function setUserIdentifier(string $userIdentifier): User
    {
        $this->userIdentifier = $userIdentifier;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFavoriteIngredients(): ArrayCollection
    {
        return $this->favoriteIngredients;
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return User
     */
    public function addFavoriteIngredient(Ingredient $ingredient): User
    {
        $this->favoriteIngredients->add($ingredient);

        return $this;
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return User
     */
    public function removeFavoriteIngredient(Ingredient $ingredient): User
    {
        $this->favoriteIngredients->removeElement($ingredient);

        return $this;
    }
}