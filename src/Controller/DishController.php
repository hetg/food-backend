<?php

namespace App\Controller;

use App\DTO\DishDto;
use App\Entity\Dish;
use App\Entity\Ingredient;
use App\Service\DishManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;

class DishController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var DishManager
     */
    private $dishManager;

    public function __construct(EntityManagerInterface $entityManager, DishManager $dishManager)
    {
        $this->entityManager = $entityManager;
        $this->dishManager = $dishManager;
    }

    /**
     * @ApiDoc\Operation(
     *     tags={"Dishes"},
     *     summary="Return list of dishes",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @Rest\Get("/dishes")
     * @Rest\View()
     *
     * @return array
     */
    public function getDishesAction(): array
    {
        return $this->entityManager->getRepository(Dish::class)->findAll();
    }

    /**
     * @param Dish $dish
     *
     * @ApiDoc\Operation(
     *     tags={"Dishes"},
     *     summary="Return dish by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Dish UUID", required=true, type="string"),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="dish", class="App\Entity\Dish", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Get("/dishes/{_uid}")
     * @Rest\View()
     *
     * @return Dish
     */
    public function getDishAction(Dish $dish): Dish
    {
        return $dish;
    }

    /**
     * @param DishDto $dishDto
     *
     * @return Dish
     * @ApiDoc\Operation(
     *     tags={"Dishes"},
     *     summary="Create dish",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(
     *          name="Dish data",
     *          in="body",
     *          description="Data for creating a dish",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=DishDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="201", description="Created"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @Rest\Post("/dishes")
     * @Rest\View(statusCode=201)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function createDishAction(DishDto $dishDto): Dish
    {
        return $this->dishManager->createDish($dishDto);
    }

    /**
     * @param DishDto $dishDto
     * @param Dish    $dish
     *
     * @return Dish
     * @ApiDoc\Operation(
     *     tags={"Dishes"},
     *     summary="Update dish",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Dish UUID", required=true, type="string"),
     *     @SWG\Parameter(
     *          name="Dish data",
     *          in="body",
     *          description="Data for updating a dish",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=DishDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="202", description="Accepted"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="dish", class="App\Entity\Dish", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Patch("/dishes/{_uid}")
     * @Rest\View(statusCode=202)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function updateDishAction(DishDto $dishDto, Dish $dish): Dish
    {
        return $this->dishManager->updateDish($dishDto, $dish);
    }

    /**
     * @param Dish    $dish
     *
     * @ApiDoc\Operation(
     *     tags={"Dishes"},
     *     summary="Delete dish",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Dish UUID", required=true, type="string"),
     *     @SWG\Response(response="204", description="No Content"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="dish", class="App\Entity\Dish", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Delete("/dishes/{_uid}")
     * @Rest\View(statusCode=204)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteDishAction(Dish $dish)
    {
        $this->dishManager->deleteDish($dish);
    }

    /**
     * @param Dish       $dish
     * @param Ingredient $ingredient
     *
     * @return Dish
     * @ApiDoc\Operation(
     *     tags={"Dishes"},
     *     summary="Add ingredient to dish by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="User UUID", required=true, type="string"),
     *     @SWG\Parameter(name="i_uid", in="path", description="Ingredient UUID", required=true, type="string"),
     *     @SWG\Response(response="202", description="Accepted"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="dish", class="App\Entity\Dish", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     * @ParamConverter(name="ingredient", class="App\Entity\Ingredient", options={"mapping" : {"i_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Patch("/dishes/{_uid}/ingredients/{i_uid}")
     * @Rest\View(statusCode=202)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addIngredientAction(Dish $dish, Ingredient $ingredient): Dish
    {
        $dish->addIngredient($ingredient);

        $this->entityManager->flush($dish);

        return $dish;
    }

}