<?php

namespace App\DTO;

use App\DTO\Interfaces\RequestDTOInterface;
use App\DTO\Interfaces\ValidatedDTOInterface;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class IngredientDto implements RequestDTOInterface, ValidatedDTOInterface
{
    /**
     * @var string
     *
     * @JMS\Type(name="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public $name;

}