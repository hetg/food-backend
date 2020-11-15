<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu")
 */
class Menu
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
     * @var ArrayCollection<Dish>|PersistentCollection<Dish>
     *
     * @ORM\OneToMany(targetEntity="Dish", mappedBy="menu")
     * @JMS\Groups({"api"})
     */
    protected $dishes;


    public function __construct()
    {
        $this->dishes = new ArrayCollection();
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
     * @return Menu
     */
    public function setUniqueIdentifier(string $uniqueIdentifier): Menu
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
     * @return Menu
     */
    public function setName(string $name): Menu
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getDishes()
    {
        return $this->dishes;
    }

    /**
     * @param Dish $dish
     *
     * @return Menu
     */
    public function addDish(Dish $dish): Menu
    {
        if (!$this->dishes->contains($dish)){
            $this->dishes->add($dish);
        }

        return $this;
    }

    /**
     * @param Dish $dish
     *
     * @return Menu
     */
    public function removeDish(Dish $dish): Menu
    {
        if ($this->dishes->contains($dish)) {
            $this->dishes->removeElement($dish);
        }

        return $this;
    }
}