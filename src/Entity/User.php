<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user", indexes={
 *         @ORM\Index(name="idx_user_identifier", columns={"_uid"})
 *     })
 */
class User extends BaseUser
{

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
     * @ORM\Column(name="_uid", type="string", length=255, unique=true, nullable=false)
     * @JMS\Type(name="string")
     * @JMS\Groups({"api"})
     * @JMS\SerializedName("_uid")
     */
    protected $uniqueIdentifier;

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
     * @var ArrayCollection<Ingredient>|PersistentCollection<Ingredient>
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
    public function getUniqueIdentifier(): string
    {
        return $this->uniqueIdentifier;
    }

    /**
     * @param string $uniqueIdentifier
     *
     * @return User
     */
    public function setUniqueIdentifier(string $uniqueIdentifier): User
    {
        $this->uniqueIdentifier = $uniqueIdentifier;

        return $this;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getFavoriteIngredients()
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