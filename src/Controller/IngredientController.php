<?php

namespace App\Controller;

use App\DTO\IngredientDto;
use App\Entity\Ingredient;
use App\Service\IngredientManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;

class IngredientController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var IngredientManager
     */
    private $ingredientManager;

    public function __construct(EntityManagerInterface $entityManager, IngredientManager $ingredientManager)
    {
        $this->entityManager = $entityManager;
        $this->ingredientManager = $ingredientManager;
    }

    /**
     * @ApiDoc\Operation(
     *     tags={"Ingredients"},
     *     summary="Return list of ingredients",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @Rest\Get("/ingredients")
     * @Rest\View()
     *
     * @return array
     */
    public function getIngredientsAction(): array
    {
        return $this->entityManager->getRepository(Ingredient::class)->findAll();
    }

    /**
     * @param Ingredient $ingredient
     *
     * @ApiDoc\Operation(
     *     tags={"Ingredients"},
     *     summary="Return ingredient by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Ingredient UUID", required=true, type="string"),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="ingredient", class="App\Entity\Ingredient", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Get("/ingredients/{_uid}")
     * @Rest\View()
     *
     * @return Ingredient
     */
    public function getIngredientAction(Ingredient $ingredient): Ingredient
    {
        return $ingredient;
    }

    /**
     * @param IngredientDto $ingredientDto
     *
     * @return Ingredient
     * @ApiDoc\Operation(
     *     tags={"Ingredients"},
     *     summary="Create ingredient",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(
     *          name="Ingredient data",
     *          in="body",
     *          description="Data for creating an ingredient",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=IngredientDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="201", description="Created"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @Rest\Post("/ingredients")
     * @Rest\View(statusCode=201)
     */
    public function createIngredientAction(IngredientDto $ingredientDto): Ingredient
    {
        return $this->ingredientManager->createIngredient($ingredientDto);
    }

    /**
     * @param IngredientDto $ingredientDto
     * @param Ingredient    $ingredient
     *
     * @return Ingredient
     * @ApiDoc\Operation(
     *     tags={"Ingredients"},
     *     summary="Update ingredient",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Ingredient UUID", required=true, type="string"),
     *     @SWG\Parameter(
     *          name="Ingredient data",
     *          in="body",
     *          description="Data for updating an ingredient",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=IngredientDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="202", description="Accepted"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="ingredient", class="App\Entity\Ingredient", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Patch("/ingredients/{_uid}")
     * @Rest\View(statusCode=202)
     */
    public function updateIngredientAction(IngredientDto $ingredientDto, Ingredient $ingredient): Ingredient
    {
        return $this->ingredientManager->updateIngredient($ingredientDto, $ingredient);
    }

    /**
     * @param Ingredient    $ingredient
     *
     * @ApiDoc\Operation(
     *     tags={"Ingredients"},
     *     summary="Delete ingredient",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Ingredient UUID", required=true, type="string"),
     *     @SWG\Response(response="204", description="No Content"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="ingredient", class="App\Entity\Ingredient", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Delete("/ingredients/{_uid}")
     * @Rest\View(statusCode=204)
     */
    public function deleteIngredientAction(Ingredient $ingredient)
    {
        $this->ingredientManager->deleteIngredient($ingredient);
    }

}