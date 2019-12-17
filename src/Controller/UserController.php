<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;

class UserController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     *
     * @ApiDoc\Operation(
     *     tags={"Users"},
     *     summary="Return user by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="User UUID", required=true, type="integer"),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="user", class="App\Entity\User", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Get("/users/{_uid}")
     * @Rest\View()
     *
     * @return User
     */
    public function getUserAction(User $user): User
    {
        return $user;
    }

    /**
     * @param User       $user
     *
     * @return array
     * @ApiDoc\Operation(
     *     tags={"Users"},
     *     summary="Return user's favorite ingredients",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="User UUID", required=true, type="integer"),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="user", class="App\Entity\User", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Get("/users/{_uid}/favorite-ingredients")
     * @Rest\View()
     *
     */
    public function getFavoriteIngredientsAction(User $user): array
    {
        return $user->getFavoriteIngredients()->toArray();
    }

    /**
     * @param User       $user
     * @param Ingredient $ingredient
     *
     * @return User
     * @ApiDoc\Operation(
     *     tags={"Users"},
     *     summary="Return user by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="User UUID", required=true, type="integer"),
     *     @SWG\Parameter(name="i_uid", in="path", description="Ingredient UUID", required=true, type="integer"),
     *     @SWG\Response(response="202", description="Accepted"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="user", class="App\Entity\User", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     * @ParamConverter(name="ingredient", class="App\Entity\Ingredient", options={"mapping" : {"i_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Patch("/users/{_uid}/favorite-ingredients/{i_uid}")
     * @Rest\View(statusCode=202)
     *
     */
    public function addFavoriteIngredientAction(User $user, Ingredient $ingredient): User
    {
        $user->addFavoriteIngredient($ingredient);

        $this->entityManager->flush($user);

        return $user;
    }

}