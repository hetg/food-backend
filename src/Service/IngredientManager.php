<?php

namespace App\Service;

use App\DTO\IngredientDto;
use App\Entity\Ingredient;
use App\Utils\UuidGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class IngredientManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create ingredient method
     *
     * @param IngredientDto $ingredientDto
     *
     * @return Ingredient
     */
    public function createIngredient(IngredientDto $ingredientDto): Ingredient
    {
        $name = $this->entityManager->getRepository(Ingredient::class)->findOneBy(['name' => $ingredientDto->name]);
        if (null !== $name){
            throw new HttpException(409, sprintf("Ingredient \"%s\" already exists", $ingredientDto->name));
        }

        $uuidGenerator = new UuidGenerator();

        $ingredient = new Ingredient();
        $ingredient->setUniqueIdentifier($uuidGenerator->generateUniqueIdentifier());
        $ingredient->setName($ingredientDto->name);

        $this->entityManager->persist($ingredient);
        $this->entityManager->flush($ingredient);

        return $ingredient;
    }

    /**
     * Update ingredient method
     *
     * @param IngredientDto $ingredientDto
     * @param Ingredient    $ingredient
     *
     * @return Ingredient
     */
    public function updateIngredient(IngredientDto $ingredientDto, Ingredient $ingredient): Ingredient
    {
        $name = $this->entityManager->getRepository(Ingredient::class)->findOneBy(['name' => $ingredientDto->name]);
        if (null !== $name){
            throw new HttpException(409, sprintf("Ingredient \"%s\" already exists", $ingredientDto->name));
        }

        $ingredient->setName($ingredientDto->name);
        $this->entityManager->flush($ingredient);

        return $ingredient;
    }

    /**
     * Delete ingredient method
     *
     * @param Ingredient    $ingredient
     */
    public function deleteIngredient(Ingredient $ingredient): void
    {
        $this->entityManager->remove($ingredient);
    }
}