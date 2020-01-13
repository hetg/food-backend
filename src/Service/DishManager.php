<?php

namespace App\Service;

use App\DTO\DishDto;
use App\Entity\Dish;
use App\Utils\UuidGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DishManager
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
     * Create dish method
     *
     * @param DishDto $dishDto
     *
     * @return Dish
     */
    public function createDish(DishDto $dishDto): Dish
    {
        $name = $this->entityManager->getRepository(Dish::class)->findOneBy(['name' => $dishDto->name]);
        if (null !== $name){
            throw new HttpException(409, sprintf("Dish \"%s\" already exists", $dishDto->name));
        }

        $uuidGenerator = new UuidGenerator();

        $dish = new Dish();
        $dish->setUniqueIdentifier($uuidGenerator->generateUniqueIdentifier());
        $dish->setName($dishDto->name);

        $this->entityManager->persist($dish);
        $this->entityManager->flush($dish);

        return $dish;
    }

    /**
     * Update dish method
     *
     * @param DishDto $dishDto
     * @param Dish    $dish
     *
     * @return Dish
     */
    public function updateDish(DishDto $dishDto, Dish $dish): Dish
    {
        $name = $this->entityManager->getRepository(Dish::class)->findOneBy(['name' => $dishDto->name]);
        if (null !== $name){
            throw new HttpException(409, sprintf("Dish \"%s\" already exists", $dishDto->name));
        }

        $dish->setName($dishDto->name);
        $this->entityManager->flush($dish);

        return $dish;
    }

    /**
     * Delete dish method
     *
     * @param Dish    $dish
     */
    public function deleteDish(Dish $dish): void
    {
        $this->entityManager->remove($dish);
    }
}