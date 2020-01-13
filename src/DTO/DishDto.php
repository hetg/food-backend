<?php

namespace App\DTO;

use App\DTO\Interfaces\RequestDTOInterface;
use App\DTO\Interfaces\ValidatedDTOInterface;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class DishDto implements RequestDTOInterface, ValidatedDTOInterface
{
    /**
     * @var string
     *
     * @JMS\Type(name="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public $name;

    /**
     * @var float
     *
     * @JMS\Type(name="float")
     * @Assert\NotBlank()
     * @Assert\Range(min="0.01", minMessage="Price can't be less that 0.01")
     */
    public $price;

}