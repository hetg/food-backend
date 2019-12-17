<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredient")
 */
class Ingredient
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @JMS\Type(name="string")
     * @JMS\Groups({"api"})
     * @Assert\NotBlank()
     */
    protected $name;

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
     * @return Ingredient
     */
    public function setUniqueIdentifier(string $uniqueIdentifier): Ingredient
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
     * @return Ingredient
     */
    public function setName(string $name): Ingredient
    {
        $this->name = $name;

        return $this;
    }

}