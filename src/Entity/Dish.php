<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="dish")
 */
class Dish
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @JMS\Type(name="string")
     * @JMS\Groups({"api"})
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     * @JMS\Type(name="float")
     * @JMS\Groups({"api"})
     * @Assert\NotBlank()
     * @Assert\Range(min="0.01", minMessage="Price can't be less that 0.01")
     */
    protected $price;

    /**
     * @var ArrayCollection<Ingredient>|PersistentCollection<Ingredient>
     *
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @JMS\Groups({"api"})
     */
    protected $ingredients;


    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Dish
     */
    public function setUniqueIdentifier(string $uniqueIdentifier): Dish
    {
        $this->uniqueIdentifier = $uniqueIdentifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Dish
     */
    public function setName(string $name): Dish
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Dish
     */
    public function setPrice(float $price): Dish
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return Dish
     */
    public function addIngredient(Ingredient $ingredient): Dish
    {
        $this->ingredients->add($ingredient);

        return $this;
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return Dish
     */
    public function removeIngredient(Ingredient $ingredient): Dish
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }
}